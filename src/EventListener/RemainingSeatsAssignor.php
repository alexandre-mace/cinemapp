<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/04/19
 * Time: 23:11
 */

namespace App\EventListener;


use App\Entity\Session;
use Doctrine\ORM\Event\LifecycleEventArgs;

class RemainingSeatsAssignor
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->assign($args);
    }

    public function assign(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Session) {
            return;
        }

        $entity->setRemainingSeats($entity->getRoom()->getMaximumSeats());
    }
}