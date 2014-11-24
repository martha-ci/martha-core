<?php

namespace Martha\Core\Authentication\Provider;

/**
 * Class AbstractOAuthProvider
 * @package Martha\Core\Authentication\Provider
 */
abstract class AbstractOAuthProvider extends AbstractProvider
{
    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return string
     */
    abstract public function getUrl();

    /**
     * Allow the client to do anything it needs to do before redirecting the user to the service.
     */
    public function prepareForRedirect()
    {
    }
}
