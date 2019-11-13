<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Pays;
use App\Entity\Comment;
use App\Entity\Joueur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class JoueurFixture extends Fixture
{
    // Ici j'ai donc créer 10 pays fakées
// Je leur ai attribué les caractéristiques qui les concernes
// Dans les pays créer j'ai aussi créer une boucle pour créer les joueurs à l'intérieur, même procéder pour l'ajout de données faker
// J'ai créer un petit algorithm pour ne pas que mon update soit avant mon create
// Enfin j'ai créer une dernière boucle commentaire pour chaque joueur et j'ai repris mon algorithm concernant les articles 
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // Créer 10 Pays fakées
        for($p = 1; $p <= 10; $p++) {
            $pays = new Pays();
            $pays
            ->setNom($faker->country())
            ->setNationalite($faker->word());
            $manager->persist($pays);
            
            //Créer entre 2 et 10 joueurs par pays
            for($j = 0; $j < mt_rand(2, 10); $j++) {
                // Algorithme pour ne pas que le date_enregistrement soit fais après le UpdateAt
                $joueur = new Joueur();
                $now = new \DateTime();
                $days = $now->diff($joueur->getDateEnregistrement())->days;
                $minimum = '-' . $days . 'days'; // -100 days
                $joueur
                ->setNom($faker->lastName())
                ->setCaract($faker->sentences(4, true))
                ->setAge($faker->numberBetween(14, 44))
                ->setTaille($faker->randomFloat(2, 1.4, 2.4))
                ->setNiveau($faker->numberBetween(65, 99))
                ->setLibre($faker->numberBetween(0, count(Joueur::LIBRE) - 1))
                ->setPrix($faker->numberBetween(0, 700000000))
                ->setDateEnregistrement($faker->dateTimeBetween('-9 months'))
                ->setUpdatedAt($faker->dateTimeBetween($minimum))
                // ->setFilename($faker->imageUrl())
                ->setPays($pays);
                $manager->persist($joueur);
                
                // On donnes des commmentaires aux joueurs
                // On s'assure aussi  que le commentaire n'ai pas été génrer avant la création du joueur 
                for($k = 1; $k < mt_rand(2, 5); $k++) {
                    $comment = new Comment();
                    // On prend la date de maintenant
                    $nowC = new \DateTime();
                    // diff recupére la différence entre deux objets DateTime
                    $daysC = $nowC->diff($joueur->getDateEnregistrement())->days;
                    // Nous concaténons le - avec la valeur $days qu'on va nous sortir suivi d'un attribut de temps
                    $minimum = ' - ' . $daysC . ' days';
                    $comment
                    ->setAuteur($faker->name)
                    ->setContenu($faker->sentences(2, true))
                    ->setCreatedAt($faker->dateTimeBetween($minimum))
                    ->setJoueur($joueur);
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
