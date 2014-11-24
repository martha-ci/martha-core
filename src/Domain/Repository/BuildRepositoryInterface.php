<?php

namespace Martha\Core\Domain\Repository;

use Martha\Core\Domain\Entity\Build;

/**
 * Class BuildRepositoryInterface
 * @package Martha\Core\Domain\Repository
 */
interface BuildRepositoryInterface extends RepositoryInterface
{
    /**
     * Restart a build.
     *
     * @param int $buildId
     */
    public function restartBuild($buildId);

    /**
     * Go find the parent build using a list of candidates from the current build's history.
     *
     * @param array $builds
     * @return Build|bool
     */
    public function getParentBuild(array $builds);
}
