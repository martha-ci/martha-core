<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Entity\User;
use Martha\Core\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Martha\Core\Persistence\Repository
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = 'Martha\Core\Domain\Entity\User';

    /**
     * @param array|string $emails
     * @return User
     */
    public function getByEmail($emails)
    {
        if (!is_array($emails)) {
            $emails = [$emails];
        }

        $builder = $this->entityManager->createQueryBuilder()
            ->select('user')
            ->from($this->entityType, 'user')
            ->join('user.emails', 'email')
            ->where('LOWER(email.email) IN (:emails)')
            ->setParameter('emails', $emails);

        return $builder->getQuery()->getOneOrNullResult();
    }
}
