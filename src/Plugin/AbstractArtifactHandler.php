<?php

namespace Martha\Core\Plugin;

use Martha\Core\Domain\Entity\Build;

/**
 * Class AbstractArtifactHandler
 * @package Martha\Core\Plugin
 */
abstract class AbstractArtifactHandler
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var AbstractPlugin
     */
    protected $plugin;

    /**
     * Set us up the handler!
     *
     * @param AbstractPlugin $plugin
     */
    public function __construct(AbstractPlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Build $build
     * @param string $artifact
     */
    abstract public function parseArtifact(Build $build, $artifact);
}
