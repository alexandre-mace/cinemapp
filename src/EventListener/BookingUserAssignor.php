<?php
    /**
     * Created by PhpStorm.
     * User: alex
     * Date: 11/04/19
     * Time: 13:37
     */
namespace App\EventListener;

use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class BookingUserAssignor
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->assign($args);
    }

    public function assign(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Booking) {
            return;
        }

        $user = $this->security->getUser();

        if ($user instanceof User) {
            $entity->setUser($user);
        }
    }
}