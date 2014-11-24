<?php

namespace Martha\Core\Domain\Entity;

/**
 * Class CreatableTrait
 * @package Martha\Core\Domain\Entity
 */
trait CreatableTrait
{
    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var User
     */
    protected $createdBy;

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return $this
     */
    public function setCreatedBy(User $createdBy = null)
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
