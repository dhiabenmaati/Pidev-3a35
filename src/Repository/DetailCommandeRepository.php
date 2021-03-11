<?php

namespace App\Repository;

use App\Entity\DetailCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailCommande[]    findAll()
 * @method DetailCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailCommande::class);
    }

    // /**
    //  * @return DetailCommande[] Returns an array of DetailCommande objects
    //  */

    public function findByCommande($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.commande = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?DetailCommande
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
