<?php

namespace Martha\Core\Domain\Service\User;

use Martha\Core\Authentication\AuthenticationResult;
use Martha\Core\Domain\Entity\User;
use Martha\Core\Hash;

/**
 * Class UserUpdaterService
 * @package Martha\Core\Domain\Service\User
 */
class UserUpdaterService
{
    /**
     * @param User $user
     * @param AuthenticationResult $result
     */
    public function updateUserFromAuthenticationResult(User $user, AuthenticationResult $result)
    {
        foreach ($user->getTokens() as $token) {
            if ($token->getService() == $result->getService()) {
                if ($token->getToken()->toArray() != $result->getCredentials()) {
                    $user->getTokens()->removeElement($token);
                } else {
                    return;
                }
            }
        }

        $token = new User\Token();
        $token->setService($result->getService());
        $token->setToken(new Hash($result->getCredentials()));

        $user->addToken($token);
    }
}
