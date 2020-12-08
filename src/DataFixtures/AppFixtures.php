<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Style;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $styles = [];
        $artists = [];

        //Style
        foreach(Style::STYLE as $i){
            $style=new Style();
            $style
            ->setName($i);
            $manager->persist($style);
            $styles[] = $style;
        }

        //Artist
        for ($i = 0; $i < 15; $i++) {
            $artist=new Artist();
            $artist
             ->setName($faker->word)
             ->setPicture($faker->imageUrl())
             ->setStyle($styles[$faker->numberBetween(0, 2)]);
 
             $manager->persist($artist);
             $artists[] = $artist;
        }

         //Album
         for ($i = 0; $i < 35; $i++) {
            $album=new Album();
            $album
                ->setName($faker->word)
                ->setReleaseYear($faker->year(2020))
                ->setArtist($artists[$faker->numberBetween(0,14)])
                ->setCover($faker->imageUrl());
            $manager->persist($album);
         }

        //USER
        $user = new User();
        $user  
         ->setEmail('admin@admin.com')
         ->setRoles(User::USER_ROLE[0])
         ->setPassword($this->encoder->encodePassword(
             $user, 'admin'
         ));

        $manager->persist($user);

        $manager->flush();
    }
}
