<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Handler\Admin\Movie\deleteActionHandler;
use App\Handler\Admin\Movie\editActionHandler;
use App\Handler\Admin\Movie\newActionHandler;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/movie", name="admin_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie_list", methods={"GET"})
     */
    public function list(MovieRepository $movieRepository): Response
    {
        return $this->render('admin/movie/list.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="movie_new", methods={"GET","POST"})
     */
    public function new(Request $request, newActionHandler $handler): Response
    {
        $form = $this->createForm(MovieType::class)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_movie_list');
        }

        return $this->render('admin/movie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_show", methods={"GET"})
     */
    public function show(Movie $movie): Response
    {
        return $this->render('admin/movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Movie $movie, editActionHandler $handler): Response
    {
        $form = $this->createForm(MovieType::class, $movie)->handleRequest($request);
        if ($handler($form)) {
            return $this->redirectToRoute('admin_movie_list', [
                'id' => $movie->getId(),
            ]);
        }

        return $this->render('admin/movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_delete", methods={"DELETE"})
     */
    public function delete(Movie $movie, deleteActionHandler $handler): Response
    {
        $handler($movie);
        return $this->redirectToRoute('admin_movie_list');
    }
}
