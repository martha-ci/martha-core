<?php

namespace Martha\Core\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Martha\Core\Domain\Entity\User\Email;
use Martha\Core\Domain\Entity\User\Token;
use Martha\Core\Hash;

/**
 * Class User
 * @package Martha\Core\Domain\Entity
 */
class User extends AbstractEntity
{
    /**
     * @var string
     */
    protected $fullName;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var ArrayCollection
     */
    protected $emails;

    /**
     * @var ArrayCollection
     */
    protected $tokens;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * Set us up the entity!
     */
    public function __construct()
    {
        $this->emails = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->created = new DateTime();
    }

    /**
     * @param string $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param ArrayCollection $emails
     * @return $this
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param Email $email
     * @return $this
     */
    public function addEmail(Email $email)
    {
        $email->setUser($this);
        $this->emails->add($email);
        return $this;
    }

    /**
     * @todo Bake in a concept of primary
     * @return string
     */
    public function getPrimaryEmail()
    {
        if (count($this->getEmails())) {
            return $this->getEmails()->first()->getEmail();
        }

        return '';
    }

    /**
     * @return ArrayCollection
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param ArrayCollection $tokens
     * @return $this
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
        return $this;
    }

    /**
     * @param Token $token
     * @return $this
     */
    public function addToken(Token $token)
    {
        $token->setUser($this);
        $this->tokens->add($token);
        return $this;
    }

    /**
     * @param string $service
     * @return Hash|false
     */
    public function getTokenForService($service)
    {
        $token = $this->tokens->filter(function (Token $token) use ($service) {
            return $token->getService() == $service;
        })->first();

        return $token ? $token->getToken() : false;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param string $publicKey
     * @return $this
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
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
}
