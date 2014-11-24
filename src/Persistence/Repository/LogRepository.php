<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\LogRepositoryInterface;

/**
 * Class LogRepository
 * @package Martha\Core\Persistence\Repository
 */
class LogRepository extends AbstractRepository implements LogRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Log';

    /**
     * {@inheritDoc}
     */
    public function clearUnreadLogs()
    {
        $dql = 'UPDATE Martha\Core\Domain\Entity\Log l SET l.read = true WHERE l.read = false';
        $this->entityManager->createQuery($dql)->execute();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteAll()
    {
        $dql = 'DELETE FROM Martha\Core\Domain\Entity\Log';
        $this->entityManager->createQuery($dql)->execute();

        return $this;
    }
}
