<?php

namespace Martha\Core\Plugin;

use Martha\Core\Plugin\RemoteProjectProvider;
use Martha\Core\Plugin\RemoteProjectProvider\AbstractRemoteProjectProvider;
use Martha\Core\System;
use Martha\Plugin\PhpCodeSniffer\Plugin;

/**
 * Class PluginManager
 * @package Martha\Core\Plugin
 */
class PluginManager
{
    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * @var array
     */
    protected $remoteProjectProviders = [];

    /**
     * @var array
     */
    protected $authenticationProviders = [];

    /**
     * @var array
     */
    protected $artifactHandlers = [];

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $viewPaths = [];

    /**
     * @var System
     */
    protected $system;

    /**
     * Set us up the PluginManager!
     *
     * @param System $system
     */
    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * Register a Plugin with Martha.
     *
     * @param string $name
     * @param AbstractPlugin $plugin
     */
    public function registerPlugin($name, AbstractPlugin $plugin)
    {
        $this->plugins[$name] = $plugin;
    }

    /**
     * Allows a plugin to register a RemoteProjectProvider.
     *
     * @param AbstractPlugin $plugin
     * @param string $provider
     * @return $this
     */
    public function registerRemoteProjectProvider(AbstractPlugin $plugin, $provider)
    {
        $this->remoteProjectProviders[] = new $provider($plugin);
        return $this;
    }

    /**
     * Allows a plugin to provide authentication for the application through a AuthenticationProvider.
     *
     * @param AbstractPlugin $plugin
     * @param string $provider
     * @return $this
     */
    public function registerAuthenticationProvider(AbstractPlugin $plugin, $provider)
    {
        $config = $plugin->getConfig();
        // todo fixme this isn't the place to store the logic for generating this URL...
        $config['callback-url'] = $this->getSystem()->getSiteUrl() . '/login/oauth-callback/' . $plugin->getName();

        $this->authenticationProviders[] = new $provider($plugin, $plugin->getConfig());
        return $this;
    }

    /**
     * Retrieve the collection of authentication providers.
     *
     * @return array
     */
    public function getAuthenticationProviders()
    {
        return $this->authenticationProviders;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function getAuthenticationProvider($name)
    {
        foreach ($this->getAuthenticationProviders() as $provider) {
            if (strtolower($provider->getName()) == strtolower($name)) {
                return $provider;
            }
        }

        return false;
    }

    /**
     * Allows a plugin to register an ArtifactHandler.
     *
     * @param AbstractPlugin $plugin
     * @param string $handler
     * @return $this
     */
    public function registerArtifactHandler(AbstractPlugin $plugin, $handler)
    {
        $this->artifactHandlers[] = new $handler($plugin);
        return $this;
    }

    /**
     * Allows a plugin to register a route with the application front-end, and define a callback for when that
     * route is hit.
     *
     * @param string $name
     * @param string $route
     * @param callable $handler
     * @return $this
     */
    public function registerHttpRouteHandler($name, $route, callable $handler)
    {
        $this->routes[$route] = [
            'name' => $name,
            'route' => $route,
            'callback' => $handler
        ];

        return $this;
    }

    /**
     * Get all the routes defined by all plugins.
     *
     * @return array
     */
    public function getHttpRoutes()
    {
        return $this->routes;
    }

    /**
     * Look for a specific Plugin-defined route.
     *
     * @param string $uri
     * @return array|bool
     */
    public function getHttpRoute($uri)
    {
        foreach ($this->routes as $route) {
            if ($route['route'] == $uri) {
                return $route;
            }
        }

        return false;
    }

    /**
     * @param Plugin $plugin
     * @param string $path
     */
    public function registerViewPath(Plugin $plugin, $path)
    {
        $this->viewPaths[$plugin->getName()][] = $path;
    }

    /**
     * @return array
     */
    public function getRegisteredViewPaths()
    {
        return $this->viewPaths;
    }

    /**
     * Get the Martha System class.
     *
     * @return System
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * @return \Martha\Core\EventManager
     */
    public function getEventManager()
    {
        return $this->system->getEventManager();
    }

    /**
     * @return \Martha\Core\Service\Logger\DatabaseLogger
     */
    public function getLogger()
    {
        return $this->system->getLogger();
    }

    /**
     * Get all RemoteProjectProviders registered.
     *
     * @return array
     */
    public function getRemoteProjectProviders()
    {
        return $this->remoteProjectProviders;
    }

    /**
     * Get a specific RemoteProjectProvider by name.
     *
     * @param string $name
     * @return bool|AbstractRemoteProjectProvider
     */
    public function getRemoteProjectProvider($name)
    {
        foreach ($this->remoteProjectProviders as $provider) {
            if ($provider->getProviderName() == $name) {
                return $provider;
            }
        }

        return false;
    }

    /**
     * Get a specific ArtifactHandler by name.
     *
     * @param string $name
     * @return bool|AbstractArtifactHandler
     */
    public function getArtifactHandler($name)
    {
        foreach ($this->artifactHandlers as $handler) {
            if ($handler->getName() == $name) {
                return $handler;
            }
        }

        return false;
    }
}
