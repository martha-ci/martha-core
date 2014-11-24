<?php

namespace Martha\Core;

use Doctrine\ORM\EntityManager;
use Martha\Core\Persistence\Repository\Factory;
use Martha\Core\Plugin\PluginManager;
use Martha\Core\Service\Logger\DatabaseLogger;

/**
 * Class System
 * @package Martha\Core
 * @todo this class is stupid; learn how to program
 * @deprecated
 */
class System
{
    /**
     * @var \Martha\Core\System
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Plugin\PluginManager
     */
    protected $pluginManager;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var Factory
     */
    protected $repositoryFactory;

    /**
     * @var DatabaseLogger
     */
    protected $logger;

    /**
     * Set us up the Martha!
     *
     * @param EntityManager $em
     * @param array $config
     */
    protected function __construct(EntityManager $em, array $config)
    {
        // todo fix me, inject this instead of EntityManager
        $this->repositoryFactory = new Factory($em);
        $this->eventManager = new EventManager();
        $this->logger = new DatabaseLogger($this->repositoryFactory->createLogRepository());

        // todo fixme: this makes testing very hard
        $this->pluginManager = new PluginManager($this);

        $this->config = $config;
        $this->loadPlugins($config);
    }

    /**
     * Load all of the plugins.
     *
     * @param array $config
     */
    protected function loadPlugins(array $config)
    {
        $plugins = isset($config['plugins']) ? $config['plugins'] : [];

        foreach ($plugins as $plugin => $config) {
            $plugin .= '\Plugin';
            if (class_exists($plugin, true)) {
                $pluginObj = new $plugin(
                    $this->pluginManager,
                    $config
                );
                $this->pluginManager->registerPlugin($plugin, $pluginObj);
            }
        }
    }

    /**
     * Get the PluginManager.
     *
     * @return PluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * @return Factory
     */
    public function getRepositoryFactory()
    {
        return $this->repositoryFactory;
    }

    /**
     * Get the URL for this Martha installation.
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return isset($this->config['site_url']) ? $this->config['site_url'] : '';
    }

    /**
     * @return DatabaseLogger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Bootstrap the Martha core system.
     *
     * @param EntityManager $em
     * @param array $config
     * @return $this
     */
    public static function initialize(EntityManager $em, array $config)
    {
        self::$instance = new self($em, $config);
        return self::$instance;
    }

    /**
     * Get an instance of the Martha core system.
     *
     * @return System
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            throw new \Exception('Martha System was not initialized');
        }
        return self::$instance;
    }
}
