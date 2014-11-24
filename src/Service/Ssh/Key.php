<?php

namespace Martha\Core\Service\Ssh;

/**
 * Class Key
 * @package Martha\Core\Service\Ssh
 */
class Key
{
    /**
     * @var string
     */
    protected $public;

    /**
     * @var string
     */
    protected $private;

    /**
     * @param string $public
     * @param string $private
     */
    public function __construct($public = '', $private = '')
    {
        $this->public = $public;
        $this->private = $private;
    }

    /**
     * @return string
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param string $public
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param string $private
     * @return $this
     */
    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
    }
}
