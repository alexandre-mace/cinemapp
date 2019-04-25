<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/04/19
 * Time: 15:24
 */

namespace App\Handler\Client\Register;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class RegisterActionHandler
{
    private $manager;
    private $flashBag;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    public function __invoke(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($form->getData());
            $this->manager->flush();
            $this->flashBag->add('success', 'L\'utilisateur a bien été ajouté.');
            return true;
        }

        return false;
    }
}