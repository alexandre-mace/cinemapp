<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/04/19
 * Time: 21:57
 */

namespace App\EventListener;


use App\Entity\Booking;
use App\Entity\Session;
use Doctrine\ORM\Event\LifecycleEventArgs;

class RemainingSeatsCalculator
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Booking) {
            return;
        }

        $session = $entity->getSession();

        if ($session instanceof Session) {
            $session->setRemainingSeats($session->getRemainingSeats() - $entity->getSeats());
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Booking) {
            return;
        }

        $session = $entity->getSession();

        if ($session instanceof Session) {
            $session->setRemainingSeats($session->getRemainingSeats() + $entity->getSeats());
        }
    }
}