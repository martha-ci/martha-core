<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\PluginRepositoryInterface;

/**
 * Class PluginRepository
 * @package Martha\Core\Persistence\Repository
 */
class PluginRepository extends AbstractRepository implements PluginRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Plugin';
}
