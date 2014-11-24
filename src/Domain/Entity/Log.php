<?php

namespace Martha\Core\Domain\Entity;

use DateTime;

/**
 * Class Log
 * @package Martha\Core\Domain\Entity
 */
class Log extends AbstractEntity
{
    /**
     * @var string
     */
    protected $level;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var boolean
     */
    protected $read = false;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param boolean $wasRead
     * @return $this
     */
    public function setRead($wasRead)
    {
        $this->read = $wasRead;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * @return bool
     */
    public function isRead()
    {
        return $this->getRead() === true;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created)
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
}
