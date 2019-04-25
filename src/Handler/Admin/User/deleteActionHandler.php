<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25/04/19
 * Time: 16:01
 */

namespace App\Handler\Admin\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class deleteActionHandler
{
    private $manager;
    private $flashBag;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    public function __invoke(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
        $this->flashBag->add('success', 'The user has been successfully deleted.');
        return true;
    }
}
