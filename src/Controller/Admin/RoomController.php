<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Form\RoomType;
use App\Handler\Admin\Room\deleteActionHandler;
use App\Handler\Admin\Room\editActionHandler;
use App\Handler\Admin\Room\newActionHandler;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/room", name="admin_")
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/", name="room_list", methods={"GET"})
     */
    public function list(RoomRepository $roomRepository): Response
    {
        return $this->render('admin/room/list.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request, newActionHandler $handler): Response
    {
        $form = $this->createForm(RoomType::class)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_room_list');
        }

        return $this->render('admin/room/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET"})
     */
    public function show(Room $room): Response
    {
        return $this->render('admin/room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room, editActionHandler $handler): Response
    {
        $form = $this->createForm(RoomType::class, $room)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_room_list', [
                'id' => $room->getId(),
            ]);
        }

        return $this->render('admin/room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_delete", methods={"DELETE"})
     */
    public function delete(Room $room, deleteActionHandler $handler): Response
    {
        $handler($room);
        return $this->redirectToRoute('admin_room_list');
    }
}
