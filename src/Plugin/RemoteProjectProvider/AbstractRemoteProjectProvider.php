<?php

namespace Martha\Core\Plugin\RemoteProjectProvider;

use Martha\Core\Domain\Entity\Project;
use Martha\Core\Domain\Entity\User;
use Martha\Core\Plugin\AbstractPlugin;

/**
 * Class AbstractRemoteProjectProvider
 * @package Martha\Core\Plugin\RemoteProjectProvider
 */
abstract class AbstractRemoteProjectProvider
{
    /**
     * @var string
     */
    protected $providerName;

    /**
     * @var \Martha\Plugin\GitHub\Plugin
     */
    protected $plugin;

    /**
     * @param AbstractPlugin $plugin
     */
    public function __construct(AbstractPlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Get the name of the RemoteProjectProvider.
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * Get a list of available projects from the remote source.
     *
     * @param User $user
     * @return array
     */
    abstract public function getAvailableProjectsForUser(User $user);

    /**
     * Get information about a specific project from the remote source.
     *
     * @param User $user
     * @param $identifier
     * @return mixed
     */
    abstract public function getProjectInformation(User $user, $identifier);

    /**
     * @param Project $project
     * @param int $projectType
     * @throws \Github\Exception\MissingArgumentException
     */
    public function onProjectCreated(Project $project, $projectType)
    {
    }
}
