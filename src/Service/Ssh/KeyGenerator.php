<?php

namespace Martha\Core\Service\Ssh;

use Crypt_RSA;

/**
 * Class KeyGenerator
 * @package Martha\Core\Service\Ssh
 */
class KeyGenerator
{
    /**
     * Generate an RSA key pair.
     *
     * @return Key
     */
    public function generateKey()
    {
        $rsa = new Crypt_RSA();
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);

        $rawKey = $rsa->createKey();

        $key = new Key($rawKey['publickey'], $rawKey['privatekey']);

        return $key;
    }
}
