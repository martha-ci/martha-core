<?php

namespace Martha\Core\Domain\Repository;

use Martha\Core\Domain\Entity\AbstractEntity;

/**
 * Class RepositoryInterface
 * @package Martha\Core\Domain\Repository
 */
interface RepositoryInterface
{
    /**
     * @param $id
     * @return \Martha\Core\Domain\Entity\AbstractEntity
     */
    public function getById($id);

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     * @return array
     */
    public function getBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @return array
     */
    public function getAll();

    /**
     * @param \Martha\Core\Domain\Entity\AbstractEntity $entity
     * @return RepositoryInterface
     */
    public function persist(AbstractEntity $entity);

    /**
     * @param \Martha\Core\Domain\Entity\AbstractEntity $entity
     * @return AbstractEntity
     */
    public function merge(AbstractEntity $entity);

    /**
     * @return RepositoryInterface
     */
    public function flush();
}
