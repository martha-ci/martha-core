<?php

namespace Martha\Core\Authentication\Provider;

use Martha\Core\Authentication\AuthenticationResult;
use Martha\Core\Plugin\AbstractPlugin;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractProvider
 * @package Martha\Core\Authentication
 */
abstract class AbstractProvider
{
    /**
     * @var \Martha\Core\Plugin\AbstractPlugin
     */
    protected $plugin;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param \Martha\Core\Plugin\AbstractPlugin
     * @param array $config
     */
    public function __construct(AbstractPlugin $plugin, array $config)
    {
        $this->plugin = $plugin;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Request $request
     * @return AuthenticationResult
     */
    abstract public function validateResult(Request $request);
}
