<?php

namespace Martha\Plugin\PhpUnit;

use Martha\Core\Plugin\AbstractPlugin;

/**
 * Class Plugin
 * @package Martha\Plugin\PhpUnit
 */
class Plugin extends AbstractPlugin
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->getPluginManager()->registerArtifactHandler(
            $this,
            '\Martha\Plugin\PhpUnit\JUnitArtifactHandler'
        );

        $this->getPluginManager()->registerArtifactHandler(
            $this,
            '\Martha\Plugin\PhpUnit\CloverArtifactHandler'
        );
    }
}
