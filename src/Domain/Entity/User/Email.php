<?php

namespace Martha\Core\Domain\Entity\User;

use Martha\Core\Domain\Entity\AbstractEntity;
use Martha\Core\Domain\Entity\User;

/**
 * Class Email
 * @package Martha\Core\Domain\Entity\User
 */
class Email extends AbstractEntity
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var User
     */
    protected $user;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
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
}
