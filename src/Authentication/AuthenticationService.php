<?php

namespace Martha\Core\Authentication;

use Martha\Core\Authentication\Provider;
use Martha\Core\Domain\Factory\User\UserFactory;
use Martha\Core\Domain\Repository\UserRepositoryInterface;
use Martha\Core\Domain\Service\User\UserUpdaterService;
use Martha\Core\Plugin\PluginManager;
use Martha\Core\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthenticationService
 * @package Martha\Core\Authentication
 */
class AuthenticationService
{
    /**
     * @var PluginManager
     */
    protected $pluginManager;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @param System $system
     * @param PluginManager $pluginManager
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(System $system, PluginManager $pluginManager, UserRepositoryInterface $userRepository)
    {
        $this->system = $system;
        $this->pluginManager = $pluginManager;
        $this->userRepository = $userRepository;
    }

    /**
     * Get the registered OAuth providers.
     *
     * @return array
     */
    public function getRegisteredOAuthProviders()
    {
        $oAuthProviders = [];

        foreach ($this->pluginManager->getAuthenticationProviders() as $provider) {
            if ($provider instanceof Provider\AbstractOAuthProvider) {
                $oAuthProviders[] = $provider;
            }
        }

        return $oAuthProviders;
    }

    /**
     * Get an authentication provider by name.
     *
     * @param string $provider
     * @return bool|Provider\AbstractProvider
     */
    public function getAuthenticationProvider($provider)
    {
        return $this->pluginManager->getAuthenticationProvider($provider);
    }

    /**
     * @param string $provider
     * @param Request $request
     * @return bool|\Martha\Core\Domain\Entity\User
     */
    public function authenticateWithOAuthProvider($provider, Request $request)
    {
        $provider = $this->pluginManager->getAuthenticationProvider($provider);

        if ($provider) {
            if (($authResult = $provider->validateResult($request)) !== false) {
                $user = $this->userRepository->getByEmail($authResult->getEmails());

                if (!$user) {
                    $user = (new UserFactory())->createFromAuthenticationResult($authResult);
                    $this->system->getEventManager()->trigger('user.created', $user, $provider);
                    $this->userRepository->persist($user)->flush();
                } else {
                    $updater = new UserUpdaterService();
                    $updater->updateUserFromAuthenticationResult($user, $authResult);
                    $this->userRepository->flush();
                }

                return $user;
            }
        }

        return false;
    }
}
