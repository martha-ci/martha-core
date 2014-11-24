<?php

namespace Martha\Core\Plugin;

/**
 * Class AbstractPlugin
 * @package Martha\Core\Plugin
 */
abstract class AbstractPlugin
{
    /**
     * @var PluginManager
     */
    protected $pluginManager;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @param PluginManager $pluginManager
     * @param array $config
     */
    public function __construct(PluginManager $pluginManager, array $config)
    {
        $this->pluginManager = $pluginManager;
        $this->config = $config;

        $this->init();
    }

    /**
     * Get the name of the plugin.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get a description of the plugin.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * User defined setup of the plugin.
     */
    abstract public function init();

    /**
     * @return PluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
}
