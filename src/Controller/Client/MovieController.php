<?php

namespace App\Controller\Client;

use App\Entity\Movie;
use App\Form\FilterMovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie", name="client_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/list", name="movie_list")
     */
    public function list(Request $request, MovieRepository $repository)
    {
        $form = $this->createForm(FilterMovieType::class)->handleRequest($request);
        return $this->render('client/movie/list.html.twig', [
            'movies' => $repository->getFilteredMovies($form->getData()),
            'form'   => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}", name="movie_show")
     */
    public function show(Movie $movie)
    {
        return $this->render('client/movie/show.html.twig', [
            'movie' => $movie
        ]);
    }
}
