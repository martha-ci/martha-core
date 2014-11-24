<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\ArtifactRepositoryInterface;

/**
 * Class ArtifactRepository
 * @package Martha\Core\Persistence\Repository
 */
class ArtifactRepository extends AbstractRepository implements ArtifactRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Artifact';
}
