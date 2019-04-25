<?php

namespace App\Controller\Client;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Handler\Client\Booking\deleteActionHandler;
use App\Handler\Client\Booking\editActionHandler;
use App\Handler\Client\Booking\newActionHandler;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking", name="client_")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="booking_list", methods={"GET"})
     */
    public function list(BookingRepository $bookingRepository): Response
    {
        return $this->render('client/booking/list.html.twig', [
            'bookings' => $bookingRepository->findBy(['user' => $this->getUser()])
        ]);
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request, newActionHandler $handler): Response
    {
        $form = $this->createForm(BookingType::class)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('client_booking_confirm', [
                    'id' => $form->getData()->getId()
                ]);
        }

        return $this->render('client/booking/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmation/{id}", name="booking_confirm", methods={"GET"})
     */
    public function confirmation(Booking $booking): Response
    {
        $this->denyAccessUnlessGranted('show', $booking);
        return $this->render('client/booking/confirmation.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        $this->denyAccessUnlessGranted('show', $booking);
        return $this->render('client/booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Booking $booking, deleteActionHandler $handler): Response
    {
        $this->denyAccessUnlessGranted('delete', $booking);
        $handler($booking);
        return $this->redirectToRoute('client_booking_list');
    }
}
