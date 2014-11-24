<?php

namespace Martha\Core\Domain\Entity;

/**
 * Class Step
 * @package Martha\Core\Domain\Entity
 */
class Step extends AbstractEntity
{
    /**
     * @var Build
     */
    protected $build;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var boolean
     */
    protected $stopOnFailure = false;

    /**
     * @var bool
     */
    protected $markBuildFailed = true;

    /**
     * @var int
     */
    protected $returnStatus;

    /**
     * @param \Martha\Core\Domain\Entity\Build $build
     * @return $this
     */
    public function setBuild($build)
    {
        $this->build = $build;
        return $this;
    }

    /**
     * @return \Martha\Core\Domain\Entity\Build
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param boolean $stopOnFailure
     * @return $this
     */
    public function setStopOnFailure($stopOnFailure)
    {
        $this->stopOnFailure = $stopOnFailure;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getStopOnFailure()
    {
        return $this->stopOnFailure;
    }

    /**
     * @param boolean $markBuildFailed
     * @return $this
     */
    public function setMarkBuildFailed($markBuildFailed)
    {
        $this->markBuildFailed = $markBuildFailed;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getMarkBuildFailed()
    {
        return $this->markBuildFailed;
    }

    /**
     * @param int $returnStatus
     * @return $this
     */
    public function setReturnStatus($returnStatus)
    {
        $this->returnStatus = $returnStatus;
        return $this;
    }

    /**
     * @return int
     */
    public function getReturnStatus()
    {
        return $this->returnStatus;
    }
}
