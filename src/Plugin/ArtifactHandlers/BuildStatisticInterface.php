<?php

namespace Martha\Core\Plugin\ArtifactHandlers;

use Martha\Core\Domain\Entity\Build;

/**
 * Class BuildStatsticInterface
 * @package Martha\Core\Plugin\ArtifactHandlers
 */
interface BuildStatisticInterface
{
    /**
     * @param Build $build
     */
    public function generateBuildStatistics(Build $build);
}
