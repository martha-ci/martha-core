<?php

namespace Martha\Core\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Martha\Core\Domain\Entity\Build\Alert;
use Martha\Core\Domain\Entity\Build\BuildException;
use Martha\Core\Domain\Entity\Build\Statistic;
use Martha\Core\Hash;

/**
 * Class Build
 * @package Martha\Core\Domain\Entity
 */
class Build extends AbstractEntity
{
    /**
     * Status for when a build is scheduled, but not yet running.
     */
    const STATUS_PENDING = 'pending';

    /**
     * Status for when a build is currently running.
     */
    const STATUS_BUILDING = 'building';

    /**
     * Status for when a build has failed.
     */
    const STATUS_FAILURE = 'failure';

    /**
     * Status for when a build has succeeded.
     */
    const STATUS_SUCCESS = 'success';

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var Build
     */
    protected $parent;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $artifacts;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $steps;

    /**
     * @var string
     */
    protected $branch;

    /**
     * @var string
     */
    protected $fork;

    /**
     * @var string
     */
    protected $forkUri;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $revisionNumber;

    /**
     * @var Hash
     */
    protected $metadata;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $wasSuccessful;

    /**
     * @var ArrayCollection
     */
    protected $statistics;

    /**
     * @var ArrayCollection
     */
    protected $alerts;

    /**
     * @var ArrayCollection
     */
    protected $exceptions;

    /**
     * Set us up the class!
     */
    public function __construct()
    {
        $this->artifacts = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->statistics = new ArrayCollection();
        $this->alerts = new ArrayCollection();
        $this->exceptions = new ArrayCollection();

        $this->metadata = new Hash();
    }

    /**
     * @param \Martha\Core\Domain\Entity\Project $project
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return \Martha\Core\Domain\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return Build
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Build $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @param string $branch
     * @return $this
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
        return $this;
    }

    /**
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param string $fork
     * @return $this
     */
    public function setFork($fork)
    {
        $this->fork = $fork;
        return $this;
    }

    /**
     * @return string
     */
    public function getFork()
    {
        return $this->fork;
    }

    /**
     * @param string $forkUri
     * @return $this
     */
    public function setForkUri($forkUri)
    {
        $this->forkUri = $forkUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getForkUri()
    {
        return $this->forkUri;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $revisionNumber
     * @return $this
     */
    public function setRevisionNumber($revisionNumber)
    {
        $this->revisionNumber = $revisionNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevisionNumber()
    {
        return $this->revisionNumber;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return boolean
     */
    public function getWasSuccessful()
    {
        return $this->getStatus() == self::STATUS_SUCCESS;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setCreated(DateTime $date)
    {
        $this->created = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $artifacts
     * @return $this
     */
    public function setArtifacts(ArrayCollection $artifacts)
    {
        $this->artifacts = $artifacts;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getArtifacts()
    {
        return $this->artifacts;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $steps
     * @return $this
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @param Hash $metadata
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return Hash
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return ArrayCollection
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * @param Statistic $statistic
     * @return $this
     */
    public function addStatistic(Statistic $statistic)
    {
        $statistic->setBuild($this);
        $this->getStatistics()->add($statistic);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * @return array
     */
    public function getFlatStatistics()
    {
        $stats = [];

        foreach ($this->getStatistics() as $statistic) {
            $stats[$statistic->getName()] = $statistic->getValue();
        }

        return $stats;
    }

    /**
     * @param ArrayCollection $statistics
     * @return $this
     */
    public function setStatistics($statistics)
    {
        $this->statistics = $statistics;
        return $this;
    }

    /**
     * @param \Martha\Core\Domain\Entity\Build\Alert $alert
     * @return $this
     */
    public function addAlert(Alert $alert)
    {
        $alert->setBuild($this);
        $this->getAlerts()->add($alert);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @param ArrayCollection $alerts
     * @return $this
     */
    public function setAlerts($alerts)
    {
        $this->alerts = $alerts;
        return $this;
    }

    /**
     * @param BuildException $exception
     * @return $this
     */
    public function addException(BuildException $exception)
    {
        $exception->setBuild($this);
        $this->getExceptions()->add($exception);
        return $this;
    }

    /**
     * @param ArrayCollection $exceptions
     * @return $this
     */
    public function setExceptions($exceptions)
    {
        $this->exceptions = $exceptions;
        return $this;
    }

    /**
     * @param string $plugin
     * @return array
     */
    public function getExceptionsByPlugin($plugin)
    {
        return $this->exceptions->filter(function (BuildException $exception) use ($plugin) {
            return $exception->getPlugin()->getKey() == $plugin;
        });
    }
}
