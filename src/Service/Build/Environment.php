<?php

namespace Martha\Core\Service\Build;

use Symfony\Component\Process\Process;

/**
 * Class Environment
 * @package Martha\Core\Service\Build
 */
class Environment
{
    /**
     * @var string
     */
    protected $tempDirectory;

    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @var string
     */
    protected $privateKeyFile;

    /**
     * Set us up the class!
     */
    public function __construct()
    {
        $this->tempDirectory = getcwd() . '/tmp';
    }

    /**
     * @return string
     */
    public function getTempDirectory()
    {
        return $this->tempDirectory;
    }

    /**
     * @param string $tempDirectory
     * @return $this
     */
    public function setTempDirectory($tempDirectory)
    {
        $this->tempDirectory = $tempDirectory;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     * @return $this
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * Set up the build environment.
     */
    public function setUp()
    {
        if (!is_dir($this->tempDirectory)) {
            if (!is_writable($this->tempDirectory)) {
                throw new \Exception('Unable to create missing temp directory: ' . $this->tempDirectory);
            }

            mkdir($this->tempDirectory);
        }

        if ($this->privateKey) {
            $this->privateKeyFile = $this->tempDirectory . '/' . md5($this->privateKey) . '_' . microtime(true);
            file_put_contents($this->privateKeyFile, $this->privateKey);
            chmod($this->privateKeyFile, 0600);
        }
    }

    /**
     * @param string $command
     * @param callable $callback
     * @return bool
     */
    public function runCommand($command, callable $callback = null)
    {
        $command = $this->wrapCommandInSshAgent($command);

        $process = new Process($command);
        $process->run($callback);

        return $process->isSuccessful();
    }

    /**
     * @param string $command
     * @return string
     */
    protected function wrapCommandInSshAgent($command)
    {
        if ($this->privateKeyFile) {
            $sshAdd = 'ssh-add ' . $this->privateKeyFile;
            $command = 'ssh-agent ' . $_SERVER['SHELL'] . ' -c \'' . $sshAdd . '; ' . addslashes($command) . '\'';
        }

        return $command;
    }

    /**
     * Cleanup the build environment.
     */
    public function cleanUp()
    {
        if ($this->privateKeyFile) {
            unlink($this->privateKeyFile);
        }
    }
}
