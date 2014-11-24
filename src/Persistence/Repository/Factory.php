<?php

namespace Martha\Core\Persistence\Repository;

use Doctrine\ORM\EntityManager;
use Martha\Core\Domain\Repository\ArtifactRepositoryInterface;
use Martha\Core\Domain\Repository\BuildRepositoryInterface;
use Martha\Core\Domain\Repository\FactoryInterface;
use Martha\Core\Domain\Repository\PluginRepositoryInterface;
use Martha\Core\Domain\Repository\ProjectRepositoryInterface;
use Martha\Core\Domain\Repository\UserRepositoryInterface;

/**
 * Class Factory
 * @package Martha\Core\Persistence\Repository
 */
class Factory implements FactoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * Set us up the Factory!
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return ArtifactRepositoryInterface
     */
    public function createArtifactRepository()
    {
        return new ArtifactRepository($this->entityManager);
    }

    /**
     * @return BuildRepositoryInterface
     */
    public function createBuildRepository()
    {
        return new BuildRepository($this->entityManager);
    }

    /**
     * @return LogRepository
     */
    public function createLogRepository()
    {
        return new LogRepository($this->entityManager);
    }

    /**
     * @return PluginRepositoryInterface
     */
    public function createPluginRepository()
    {
        return new PluginRepository($this->entityManager);
    }

    /**
     * @return ProjectRepositoryInterface
     */
    public function createProjectRepository()
    {
        return new ProjectRepository($this->entityManager);
    }

    /**
     * @return UserRepositoryInterface
     */
    public function createUserRepository()
    {
        return new UserRepository($this->entityManager);
    }
}
