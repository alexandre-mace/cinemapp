<?php

namespace App\Controller\Client;

use App\Form\RegistrationType;
use App\Handler\Client\Register\RegisterActionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="client_register")
     */
    public function register(Request $request, RegisterActionHandler $handler)
    {
        $form = $this->createForm(RegistrationType::class)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('client_home');
        }
        return $this->render('client/register.html.twig', ['form' => $form->createView()]);
    }
}
