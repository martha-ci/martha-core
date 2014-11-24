<?php

namespace Martha\Plugin\PhpMessDetector;

use Martha\Core\Plugin\AbstractPlugin;

/**
 * Class Plugin
 * @package Martha\Plugin\PhpMessDetector
 */
class Plugin extends AbstractPlugin
{
    /**
     * Set us up the plugin!
     */
    public function init()
    {
        $this->getPluginManager()->registerArtifactHandler(
            $this,
            '\Martha\Plugin\PhpMessDetector\PhpMdArtifactHandler'
        );
    }
}
