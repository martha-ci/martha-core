<?php

namespace Martha\Core\Authentication;

/**
 * Class PasswordFactory
 * @package Martha\Core\Authentication
 */
class PasswordFactory
{
    /**
     * Creates a hashed password string for the provided password.
     *
     * @param string $password
     * @return string
     */
    public function create($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Determines if the passed plaintext $password matches the correct hash $hash.
     *
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public function validate($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
