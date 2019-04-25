<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\Admin\User\deleteActionHandler;
use App\Handler\Admin\User\editActionHandler;
use App\Handler\Admin\User\newActionHandler;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="admin_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, newActionHandler $handler): Response
    {
        $form = $this->createForm(UserType::class)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, editActionHandler $handler): Response
    {
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_user_list', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(User $user, deleteActionHandler $handler): Response
    {
        $handler($user);
        return $this->redirectToRoute('admin_user_list');
    }
}
