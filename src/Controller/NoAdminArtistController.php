<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Style;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoAdminArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist.index")
     */
    public function index(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findAll();
        return $this->render('no_admin_artist/index.html.twig', [
            'controller_name' => 'NoAdminArtistController',
            'artists' => $artists
        ]);
    }

    /**
     * @Route("/artist/{id}", name="artist.show")
     */
    public function show(Artist $artist, AlbumRepository $albumRepository, ArtistRepository $artistRepository): Response
    {
        $albums = $albumRepository->getByID($artist->getId());
        $artists = $artistRepository->getByStyle($artist->getStyle());
        return $this->render('no_admin_artist/show.html.twig', [
            'controller_name' => 'NoAdminArtistController',
            'artist' => $artist,
            'albums' => $albums,
            'artists' => $artists
        ]);
    }
}
