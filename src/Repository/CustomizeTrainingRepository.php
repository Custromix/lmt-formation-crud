<?php

namespace App\Repository;

use App\Entity\CustomizeTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomizeTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomizeTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomizeTraining[]    findAll()
 * @method CustomizeTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomizeTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomizeTraining::class);
    }

    // /**
    //  * @return CustomizeTraining[] Returns an array of CustomizeTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomizeTraining
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
