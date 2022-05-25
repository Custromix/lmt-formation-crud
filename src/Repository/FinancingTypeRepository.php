<?php

namespace App\Repository;

use App\Entity\FinancingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinancingType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinancingType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinancingType[]    findAll()
 * @method FinancingType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancingTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinancingType::class);
    }

    // /**
    //  * @return FinancingType[] Returns an array of FinancingType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinancingType
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
