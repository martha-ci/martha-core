<?php

namespace Martha\Plugin\PhpCodeSniffer;

use Martha\Core\Domain\Entity\Build;
use Martha\Core\Plugin\AbstractArtifactHandler;
use Martha\Core\Plugin\ArtifactHandlers\ExceptionWriterInterface;
use Martha\Core\Plugin\ArtifactHandlers\TextBasedResultInterface;

/**
 * Class CheckstyleArtifactHandler
 * @package Martha\Plugin\PhpCodeSniffer
 */
class CheckstyleArtifactHandler extends AbstractArtifactHandler implements
    TextBasedResultInterface,
    ExceptionWriterInterface
{
    /**
     * @var string
     */
    protected $name = 'phpcs';

    /**
     * @var Build
     */
    protected $build;

    /**
     * @var bool|\SimpleXmlElement
     */
    protected $artifact;

    /**
     * {@inheritDoc}
     */
    public function parseArtifact(Build $build, $artifact)
    {
        $this->build = $build;
        $this->artifact = $artifact ? new \SimpleXMLElement($artifact) : false;
    }

    /**
     * {@inheritDoc}
     */
    public function getSimpleTextResult()
    {
        $violationCount = 0;

        if ($this->artifact) {
            foreach ($this->artifact->xpath('//file') as $file) {
                foreach ($file->xpath('//error') as $error) {
                    $violationCount++;
                }
            }

            $result = "Detected {$violationCount} Standards Violation" .
                ($violationCount > 1 ? "s" : "") . "\n";
        } else {
            $result = "No Standards Violations Detected\n";
        }

        return $result;
    }

    /**
     * Log any build exceptions from the CheckStyle report.
     */
    public function logBuildExceptions()
    {
        if ($this->artifact) {
            foreach ($this->artifact->xpath('//file') as $file) {
                foreach ($file->xpath('//error') as $error) {
                    $exception = new Build\BuildException();
                    $exception->setAsset(basename($file['name']));
                    $exception->setReference($error['line']);
                    $exception->setType('E');
                    $exception->setMessage($error['message']);

                    $this->build->addException($exception);
                }
            }
        }
    }

    /**
     * Strip off the irrelevant part of the file name (build path) and return the shortened file name.
     *
     * @param string $file
     * @return string
     */
    protected function stripBuildPath($file)
    {
        $base = $this->build->getProject()->getName() . '/' . $this->build->getId();
        return substr($file, strpos($file, $base) + strlen($base) + 1);
    }
}
