<?php

namespace Martha\Core\Persistence\Event\Subscriber;

use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Martha\Core\Domain\Entity\CreatableInterface;
use Martha\Core\Domain\Entity\User;

/**
 * Timestamped event subscriber.
 */
class CreatableSubscriber implements EventSubscriber
{
    /**
     * @var User
     */
    protected $login;

    /**
     * Constructor.
     *
     * @param User $login
     */
    public function __construct($login)
    {
        $this->login = $login;
    }

    /**
     * prePersist event handler.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof CreatableInterface) {
            return;
        }

        $entity->setCreated(new Datetime(null, new \DateTimeZone('GMT')));
        $entity->setCreatedBy($this->login->getIdentity());
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            // @codingStandardsIgnoreStart
            Events::prePersist,
            // @codingStandardsIgnoreEnd
        ];
    }
}
