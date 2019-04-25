<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/04/19
 * Time: 13:37
 */
namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordEncoder
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->encode($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->encode($args);
    }

    public function encode(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        if ($entity->getPlainPassword()) {
            $password = $this->encoder->encodePassword($entity, $entity->getPlainPassword());
            $entity->setPassword($password);
        }
    }
}