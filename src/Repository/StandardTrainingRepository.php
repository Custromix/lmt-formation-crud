<?php

namespace App\Repository;

use App\Entity\StandardTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandardTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandardTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandardTraining[]    findAll()
 * @method StandardTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandardTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandardTraining::class);
    }

    // /**
    //  * @return StandardTraining[] Returns an array of StandardTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StandardTraining
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
