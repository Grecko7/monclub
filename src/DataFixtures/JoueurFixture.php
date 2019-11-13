<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Joueur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class JoueurFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_EN');
        for($i = 0; $i < 100; $i++) {
            $joueur = new Joueur();
            $joueur
            ->setNom($faker->lastName())
            ->setCaract($faker->sentences(4, true))
            ->setAge($faker->numberBetween(14, 44))
            ->setTaille($faker->numberBetween(1.5, 2.1))
            ->setNiveau($faker->numberBetween(65, 99))
            ->setPays($faker->numberBetween(0, count(Joueur::PAYS) - 1))
            ->setLibre($faker->numberBetween(0, count(Joueur::LIBRE) - 1))
            ->setPrix($faker->numberBetween(0, 700000000));
            
            $manager->persist($joueur);
        }
        $manager->flush();
    }
}
