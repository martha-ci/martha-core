<?php

namespace Martha\Core\Domain\Entity;

/**
 * Class Plugin
 * @package Martha\Core\Domain\Entity
 */
class Plugin extends AbstractEntity
{
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
    protected $key;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $updateableVersion;

    /**
     * @var string
     */
    protected $updateableVersionNotes;

    /**
     * @var boolean
     */
    protected $enabled = false;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime
     */
    protected $lastEnabled;

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
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $updatableVersion
     * @return $this
     */
    public function setUpdateableVersion($updatableVersion)
    {
        $this->updateableVersion = $updatableVersion;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateableVersion()
    {
        return $this->updateableVersion;
    }

    /**
     * @param string $updatableVersionNotes
     * @return $this
     */
    public function setUpdateableVersionNotes($updatableVersionNotes)
    {
        $this->updateableVersionNotes = $updatableVersionNotes;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateableVersionNotes()
    {
        return $this->updateableVersionNotes;
    }

    /**
     * @param boolean $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
     * @param \DateTime $lastEnabled
     * @return $this
     */
    public function setLastEnabled($lastEnabled)
    {
        $this->lastEnabled = $lastEnabled;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastEnabled()
    {
        return $this->lastEnabled;
    }
}
