<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25/04/19
 * Time: 16:01
 */

namespace App\Handler\Admin\Session;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class newActionHandler
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
            $this->flashBag->add('success', 'The session has been successfully added.');
            return true;
        }

        return false;    }
}
