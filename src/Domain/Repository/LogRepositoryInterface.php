<?php

namespace Martha\Core\Domain\Repository;

/**
 * Interface LogRepositoryInterface
 * @package Martha\Core\Domain\Repository
 */
interface LogRepositoryInterface extends RepositoryInterface
{
    /**
     * @return $this
     */
    public function clearUnreadLogs();

    /**
     * @return $this
     */
    public function deleteAll();
}
