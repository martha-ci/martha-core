<?php

namespace Martha\Core\Plugin\ArtifactHandlers;

/**
 * Interface TextBasedResultInterface
 * @package Martha\Core\Plugin\ArtifactHandlers
 */
interface TextBasedResultInterface
{
    /**
     * @return string
     */
    public function getSimpleTextResult();
}
