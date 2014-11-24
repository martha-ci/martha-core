<?php

namespace Martha\Core\Persistence\Repository;

use DomainException;
use Doctrine\ORM\EntityManager;
use Martha\Core\Domain\Entity\AbstractEntity;
use Martha\Core\Domain\Repository\RepositoryInterface;

/**
 * Class AbstractRepository
 * @package Martha\Core\Persistence\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityType;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager
     * @throws DomainException
     */
    public function __construct(EntityManager $entityManager)
    {
        if (!class_exists($this->entityType)) {
            throw new DomainException('Protected property $entityType must specify fully qualified Entity class name');
        }

        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        return $this->entityManager->find($this->entityType, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        return $this->entityManager->getRepository($this->entityType)->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function getBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityManager->getRepository($this->entityType)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritDoc}
     */
    public function persist(AbstractEntity $entity)
    {
        $this->entityManager->persist($entity);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function merge(AbstractEntity $entity)
    {
        return $this->entityManager->merge($entity);
    }

    /**
     * {@inheritDoc}
     */
    public function flush(AbstractEntity $entity = null)
    {
        $this->entityManager->flush($entity);
        return $this;
    }
}
