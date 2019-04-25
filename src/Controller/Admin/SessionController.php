<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use App\Form\SessionType;
use App\Handler\Admin\Session\deleteActionHandler;
use App\Handler\Admin\Session\editActionHandler;
use App\Handler\Admin\Session\newActionHandler;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/session", name="admin_")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="session_list", methods={"GET"})
     */
    public function list(SessionRepository $sessionRepository): Response
    {
        return $this->render('admin/session/list.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="session_new", methods={"GET","POST"})
     */
    public function new(Request $request, newActionHandler $handler): Response
    {
        $form = $this->createForm(SessionType::class)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_session_list');
        }

        return $this->render('admin/session/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="session_show", methods={"GET"})
     */
    public function show(Session $session): Response
    {
        return $this->render('admin/session/show.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="session_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Session $session, editActionHandler $handler): Response
    {
        $form = $this->createForm(SessionType::class, $session)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_session_list', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('admin/session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="session_delete", methods={"DELETE"})
     */
    public function delete(Session $session, deleteActionHandler $handler): Response
    {
        $handler($session);
        return $this->redirectToRoute('admin_session_list');
    }
}
