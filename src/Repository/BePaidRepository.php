<?php

namespace App\Repository;

use App\Entity\BePaid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BePaid|null find($id, $lockMode = null, $lockVersion = null)
 * @method BePaid|null findOneBy(array $criteria, array $orderBy = null)
 * @method BePaid[]    findAll()
 * @method BePaid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BePaidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BePaid::class);
    }

    public function deleteBePaid(BePaid $deleteBepaid)
    {
        $insertSessionAndDateAndSessionCustomer = $this->getEntityManager()->getConnection()->prepare("DELETE FROM be_paid WHERE FINANCING_TYPE_ID = :idFinancing AND SESSION_ID = :idSession");
        $insertSessionAndDateAndSessionCustomer->bindValue(':idFinancing', $deleteBepaid->getFinancingType()->getOldId());
        $insertSessionAndDateAndSessionCustomer->bindValue(':idSession', $deleteBepaid->getSession()->getId());
        $insertSessionAndDateAndSessionCustomer->executeQuery();
    }

    // /**
    //  * @return BePaid[] Returns an array of BePaid objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BePaid
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
