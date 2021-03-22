<?php

namespace App\Repository;

use App\Entity\EnchereEncours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnchereEncours|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnchereEncours|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnchereEncours[]    findAll()
 * @method EnchereEncours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnchereEncoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnchereEncours::class);
    }

    // /**
    //  * @return EnchereEncours[] Returns an array of EnchereEncours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnchereEncours
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
