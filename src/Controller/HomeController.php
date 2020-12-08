<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        $albums = $albumRepository->OrderBy();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'albums' => $albums
        ]);
    }
}
