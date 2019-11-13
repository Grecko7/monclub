<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Joueur;
use App\Entity\JoueurSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
* @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
* @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
* @method Joueur[]    findAll()
* @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }
    
    /**
    * @return Query
    */
    public function findAllVisibleQuery(JoueurSearch $search) : Query
    {
        $query = $this->createQueryBuilder('j');

        if ($search->getMaxNiveau()) {
            $query = $query
            ->andWhere('j.Niveau <= :maxniveau')
            ->setParameter('maxniveau', $search->getMaxNiveau());
        }
        if ($search->getMinNiveau()) {
            $query = $query
            ->andWhere('j.Niveau >= :minniveau')
            ->setParameter('minniveau', $search->getMinNiveau());
        }
        if ($search->getMaxPrice()) {
            $query = $query
            ->andWhere('j.Prix <= :maxprice')
            ->setParameter('maxprice', $search->getMaxPrice());
        }
        if ($search->getMinPrice()) {
            $query = $query
            ->andWhere('j.Prix >= :minprice')
            ->setParameter('minprice', $search->getMinPrice());
        }
        if ($search->getLangages()->count() > 0) {
            $k = 0;          
            foreach ($search->getLangages() as $k => $langage) {
            $k++;
               $query = $query
               ->andWhere(":langage$k MEMBER OF j.langages")
               ->setParameter("langage$k", $langage);
            }
        }
        return $query->getQuery();
    }
    
    /**
    * @return Joueur[]
    */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('j')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    }



    // /**
    //  * @return Joueur[] Returns an array of Joueur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
        ->andWhere('j.exampleField = :val')
        ->setParameter('val', $value)
        ->orderBy('j.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    }
    */
    
    /*
    public function findOneBySomeField($value): ?Joueur
    {
        return $this->createQueryBuilder('j')
        ->andWhere('j.exampleField = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
    */
}
