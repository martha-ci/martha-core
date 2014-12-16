<?php

namespace Martha\Core\Job;

use Martha\Core\Domain\Entity\Artifact;
use Martha\Core\Domain\Entity\Build;
use Martha\Core\Domain\Entity\Step;
use Martha\Core\Domain\Repository\BuildRepositoryInterface;
use Martha\Core\Plugin\ArtifactHandlers\BuildStatisticInterface;
use Martha\Core\Service\Build\Environment;
use Martha\Core\Scm\Provider\AbstractProvider;
use Martha\Core\Scm\Provider\ProviderFactory;
use Martha\Core\System;
use Martha\Core\StdLib\Date\Comparison;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Runner
 * @package Martha\Core\Job
 */
class Runner
{
    /**
     * @var \Martha\Core\System
     */
    protected $system;

    /**
     * @var string
     */
    protected $jobId;

    /**
     * @var string
     */
    protected $buildDirectory;

    /**
     * @var string
     */
    protected $dataDirectory;

    /**
     * @var string
     */
    protected $workingDir;

    /**
     * @var string
     */
    protected $outputDir;

    /**
     * @var string
     */
    protected $outputFile;

    /**
     * @var \Martha\Core\Domain\Repository\BuildRepositoryInterface
     */
    protected $buildRepository;

    /**
     * @var AbstractProvider
     */
    protected $scm;

    /**
     * Set us up the class! Take the Build and configuration to build the commit.
     *
     * @param System $system
     * @param BuildRepositoryInterface $buildRepo
     * @param array $config
     */
    public function __construct(System $system, BuildRepositoryInterface $buildRepo, array $config = [])
    {
        $this->system = $system;
        $this->buildRepository = $buildRepo;

        if (isset($config['data-directory'])) {
            $this->dataDirectory = $config['data-directory'];
        }

        if (isset($config['build-directory'])) {
            $this->buildDirectory = $config['build-directory'];
        }
    }

    /**
     * Kick off the build process and return whether the build was successful or not.
     *
     * @todo Break out
     * @param int $buildId
     * @return bool
     */
    public function run($buildId)
    {
        /**
         * @var Build $build
         */
        $build = $this->buildRepository->getById($buildId);

        $build->setStatus(Build::STATUS_BUILDING);
        $this->buildRepository->flush();

        $this->system->getEventManager()->trigger('build.started', $build);

        $this->setupEnvironment($build);
        $this->checkoutSourceCode($build);

        $this->setParentBuild($build, $this->scm);

        $script = $this->parseBuildScript();

        if (!$script) {
            $this->completeBuild($build, false);
            return false;
        }

        $start = microtime(true);

        $this->log('Build started at: <strong>' . date('j M Y h:i:s A', $start) . '</strong>'. PHP_EOL);
        $status = [];

        if ($script['build']) {
            $status = $this->runBuildSteps($build, $script['build']);
        }

        $end = microtime(true);

        $this->log(
            'Build completed at: <strong>' . date('j M Y h:i:s A', $end) . '</strong>' . PHP_EOL .
            'Build duration: <strong>' . Comparison::difference($start, $end) . '</strong>'
        );

        if (isset($script['artifacts'])) {
            $this->parseBuildArtifacts($build, $script['artifacts']);
        }

        $this->cleanupBuild($build);

        $wasSuccessful = $this->wasBuildSuccessful($status);
        $this->completeBuild($build, $wasSuccessful);

        return $wasSuccessful;
    }

    /**
     * @param Build $build
     * @param AbstractProvider $scm
     */
    protected function setParentBuild(Build $build, AbstractProvider $scm)
    {
        $revisionNo = $build->getRevisionNumber();

        $revisions = $scm->getHistory($revisionNo);

        if (count($revisions)) {
            $parent = $this->buildRepository->getParentBuild($revisions);

            if ($parent) {
                $build->setParent($parent);
            }
        }
    }

    /**
     * @param Build $build
     * @param array $artifacts
     */
    protected function parseBuildArtifacts(Build $build, array $artifacts)
    {
        foreach ($artifacts as $pluginHelper => $artifactFile) {
            $artifactFile = $this->parseBuildScriptLine($artifactFile);
            $artifact = new Artifact();
            $artifact->setBuild($build);
            $artifact->setHelper($pluginHelper);
            $artifact->setFile($artifactFile);

            $build->getArtifacts()->add($artifact);
        }
    }

    /**
     * @param array $steps
     * @return bool
     */
    protected function wasBuildSuccessful(array $steps)
    {
        $wasSuccessful = true;

        foreach ($steps as $stepStatus) {
            $wasSuccessful = $wasSuccessful && $stepStatus == 0;
        }

        return $wasSuccessful;
    }

    /**
     * @param Build $build
     * @param bool $success
     */
    protected function completeBuild(Build $build, $success)
    {
        // Loop each artifact generated by the build:
        foreach ($build->getArtifacts() as $artifact) {
            // Get the handler for the artifact:
            $artifactHandler = $this->system->getPluginManager()->getArtifactHandler($artifact->getHelper());

            // If we're an instance of BuildStatisticInterface, generate the relevant statistics:
            if ($artifactHandler && $artifactHandler instanceof BuildStatisticInterface) {
                $artifactHandler->parseArtifact($build, file_get_contents($artifact->getFile()));
                $artifactHandler->generateBuildStatistics($build);
            }
        }

        $build->setStatus($success ? Build::STATUS_SUCCESS : Build::STATUS_FAILURE);
        $this->buildRepository->flush();

        $this->system->getEventManager()->trigger('build.complete', $build);
        $this->system->getEventManager()->trigger('build.' . ($success ? 'success' : 'failure'), $build);
    }

    /**
     * Log a message to the console output file.
     *
     * @throws \Exception
     * @param string $message
     */
    protected function log($message)
    {
        if (!$this->outputFile) {
            throw new \Exception('Attempting to log before setting up log file');
        }

        file_put_contents($this->outputFile, $message . PHP_EOL, FILE_APPEND);
    }

    /**
     * Setup the directory structure needed for the build.
     *
     * @param Build $build
     * @return $this
     */
    protected function setupEnvironment(Build $build)
    {
        $environment = new Environment();
        $environment->setPrivateKey($build->getProject()->getCreatedBy()->getPrivateKey());
        $environment->setUp();

        $this->system->getEventManager()->trigger('build.pre.environment', $build);

        $this->workingDir = $this->buildDirectory . '/' .
            $build->getProject()->getName() . '/' . $build->getId();
        $this->outputDir = $this->dataDirectory . '/' .
            $build->getProject()->getName() . '/' . $build->getId();

        if (!file_exists($this->workingDir)) {
            mkdir($this->workingDir, 0775, true);
        }

        if (!file_exists($this->outputDir)) {
            mkdir($this->outputDir, 0775, true);
        }

        $this->outputFile = $this->outputDir . '/console.html';
        touch($this->outputFile);

        $this->scm = ProviderFactory::createForBuild($build);
        $this->scm->setEnvironment($environment);
        $this->scm->setLogFile($this->outputFile);

        $this->system->getEventManager()->trigger('build.post.environment', $build);

        return $this;
    }

    /**
     * @param Build $build
     * @return bool
     * @throws \Exception
     */
    protected function checkoutSourceCode(Build $build)
    {
        $this->system->getEventManager()->trigger('build.pre.source', $build);

        $this->log('Checking out project source code...');
        $this->log('-- SCM: ' . $build->getProject()->getScm());
        $this->log('-- Repository: ' . $this->scm->getRepository());

        if (!$this->scm->cloneRepository($this->workingDir)) {
            $this->log('-- Failed to checkout source code');
            return false;
        }

        $this->scm->setRepository($this->workingDir);

        if ($build->getRevisionNumber()) {
            $this->log('-- Revno: ' . $build->getRevisionNumber());
            $this->scm->checkout($build->getRevisionNumber());
        }

        $this->log(''); // force a newline

        $this->system->getEventManager()->trigger('build.post.source', $build);

        return true;
    }

    /**
     * Locates and parses the Yaml build script into an array and returns it.
     *
     * @throws \Exception
     * @return bool|array
     */
    protected function parseBuildScript()
    {
        if (!file_exists($this->workingDir . '/martha.yml')) {
            $this->log('<strong>No <code>martha.yml</code> file found in the root of the source code</strong>');
            return false;
        }

        $yaml = new Yaml();
        $script = $yaml->parse($this->workingDir . '/martha.yml');

        return $script;
    }

    /**
     * @param Build $build
     * @param array $steps
     * @throws \Exception
     */
    public function runBuildSteps(Build $build, array $steps)
    {
        $status = [];

        foreach ($steps as $commandIndex => $command) {
            $step = new Step();
            $step->setBuild($build);
            $step->setCommand($command['command']);

            if (isset($command['stopOnFailure'])) {
                $step->setStopOnFailure((bool)$command['stopOnFailure']);
            }

            if (isset($command['markBuildFailed'])) {
                $step->setMarkBuildFailed((bool)$command['markBuildFailed']);
            }

            $return = $this->runCommand($step->getCommand());

            if ($step->getMarkBuildFailed()) {
                $status[$commandIndex] = $return;
            }

            $step->setReturnStatus($return);

            $build->getSteps()->add($step);

            $this->log("\nCommand returned status [{$return}].\n");

            if ($return != 0 && $step->getStopOnFailure()) {
                $this->log('Build halting due to failure');
                break;
            }

            $this->log(''); // force a newline after each command
        }

        return $status;
    }

    /**
     * Runs a specific command in the build process.
     *
     * @param string $command
     * @return int
     */
    protected function runCommand($command)
    {
        $command = $this->parseBuildScriptLine($command);

        $config = $this->system->getConfig();

        $this->log("<strong>$ {$command}</strong>");

        $process = new Process($command);
        //$process->setTty(true);

        if (isset($config['env']) && isset($config['env']['path'])) {
            $process->setEnv([
                'PATH' => $config['env']['path']
            ]);
        }

        $process->run(function ($type, $buffer) {
            echo "FOOOO";
            file_put_contents($this->outputFile, $buffer, FILE_APPEND);
        });

        return $process->getExitCode();

//        $proc = proc_open(
//            $command,
//            [
//                '1' => ['file', $this->outputFile, 'a'],
//                '2' => ['file', $this->outputFile, 'a'],
//            ],
//            $pipes,
//            $this->workingDir,
//            [
//                'PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin'
//            ]
//        );
//
//        $return = proc_close($proc);
//
//        return $return;
    }

    /**
     * @param string $line
     * @return string
     */
    protected function parseBuildScriptLine($line)
    {
        return str_replace('${outputdir}', $this->outputDir, $line);
    }

    /**
     * Cleans up after the build, removing unnecessary files, etc.
     *
     * @param Build $build
     */
    protected function cleanupBuild(Build $build)
    {
        $this->system->getEventManager()->trigger('build.pre.cleanup', $build);

        file_put_contents($this->outputFile, $this->colorizeOutput(file_get_contents($this->outputFile)));

        // empty out the build directory:
        exec('rm -rf ' . $this->workingDir);

        $this->system->getEventManager()->trigger('build.post.cleanup', $build);
    }

    /**
     * Take the console output and turn any color sequences into span tags for colorization.
     *
     * @param string $text
     * @return string
     */
    protected function colorizeOutput($text)
    {
        $text = str_replace(
            ["\033[0;32m", "\033[31;31m", "\033[33;33m", "\033[0m"],
            ['<span class="success">', '<span class="error">', '<span class="info">', '</span>'],
            $text
        );

        return $text;
    }
}
