<?php

namespace Martha\Core\Domain\Repository;

/**
 * Class FactoryInterface
 * @package Martha\Core\Domain\Repository
 */
interface FactoryInterface
{
    /**
     * @return ArtifactRepositoryInterface
     */
    public function createArtifactRepository();

    /**
     * @return BuildRepositoryInterface
     */
    public function createBuildRepository();

    /**
     * @return ProjectRepositoryInterface
     */
    public function createProjectRepository();
}
