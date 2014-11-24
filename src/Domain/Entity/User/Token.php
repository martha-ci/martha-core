<?php

namespace Martha\Core\Domain\Entity\User;

use Martha\Core\Domain\Entity\AbstractEntity;
use Martha\Core\Domain\Entity\User;
use Martha\Core\Hash;

/**
 * Class Token
 * @package Martha\Core\Domain\Entity\User
 */
class Token extends AbstractEntity
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \DateTime
     */
    protected $expires;

    /**
     * Set us up the class!
     */
    public function __construct()
    {
        $this->token = new Hash();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return Hash
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param Hash $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param \DateTime $expires
     * @return $this
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }
}
