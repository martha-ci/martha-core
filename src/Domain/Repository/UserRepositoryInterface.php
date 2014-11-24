<?php

namespace Martha\Core\Domain\Repository;

use Martha\Core\Domain\Entity\User;

/**
 * Class UserRepositoryInterface
 * @package Martha\Core\Domain\Repository
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array|string $emails
     * @return User
     */
    public function getByEmail($emails);
}
