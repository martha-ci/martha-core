<?php

namespace Martha\Plugin\PhpCodeSniffer;

use Martha\Core\Plugin\AbstractPlugin;

/**
 * Class Plugin
 * @package Martha\Plugin\PhpCodeSniffer
 */
class Plugin extends AbstractPlugin
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->getPluginManager()->registerViewPath($this, __DIR__ . '/view');

        $this->getPluginManager()->registerArtifactHandler(
            $this,
            '\Martha\Plugin\PhpCodeSniffer\CheckstyleArtifactHandler'
        );
    }
}
