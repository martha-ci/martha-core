<?php

namespace Martha\Core\Domain\Entity;

/**
 * Class AbstractEntity
 * @package Martha\Core\Domain\Entity
 */
abstract class AbstractEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
