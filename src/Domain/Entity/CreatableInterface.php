<?php

namespace Martha\Core\Domain\Entity;

/**
 * Interface CreatableInterface
 * @package Martha\Core\Domain\Entity
 */
interface CreatableInterface
{
    /**
     * @return User
     */
    public function getCreated();

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated(\DateTime $created);

    /**
     * @return \DateTime
     */
    public function getCreatedBy();

    /**
     * @param User $user
     * @return $this
     */
    public function setCreatedBy(User $user);
}
