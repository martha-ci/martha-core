<?php

namespace Martha\Core\Plugin\ArtifactHandlers;

/**
 * Class ExceptionWriterInterface
 * @package Martha\Core\Plugin\ArtifactHandlers
 */
interface ExceptionWriterInterface
{
    public function logBuildExceptions();
}
