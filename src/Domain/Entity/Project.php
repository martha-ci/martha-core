<?php

namespace Martha\Core\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Project
 * @package Martha\Core\Domain\Entity
 */
class Project extends AbstractEntity implements CreatableInterface
{
    use CreatableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $scm;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var boolean
     */
    protected $private;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $builds;

    /**
     * Set us up the class!
     */
    public function __construct()
    {
        $this->builds = new ArrayCollection();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $scm
     * @return $this
     */
    public function setScm($scm)
    {
        $this->scm = $scm;
        return $this;
    }

    /**
     * @return string
     */
    public function getScm()
    {
        return $this->scm;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param boolean $private
     * @return $this
     */
    public function setPrivate($private)
    {
        $this->private = $private === true;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $builds
     * @return $this
     */
    public function setBuilds(ArrayCollection $builds)
    {
        $this->builds = $builds;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getBuilds()
    {
        return $this->builds;
    }

    /**
     * @return \Martha\Core\Domain\Entity\Build
     */
    public function getMostRecentBuild()
    {
        $recent = null;

        foreach ($this->getBuilds() as $build) {
            if (is_null($recent) || $build->getCreated() > $recent->getCreated()) {
                $recent = $build;
            }
        }

        return $recent;
    }
}
