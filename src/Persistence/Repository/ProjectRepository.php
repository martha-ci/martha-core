<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\ProjectRepositoryInterface;

/**
 * Class ProjectRepository
 * @package Martha\Core\Persistence\Repository
 */
class ProjectRepository extends AbstractRepository implements ProjectRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Project';
}
