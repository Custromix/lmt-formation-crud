<?php

namespace App\Repository;

use App\Entity\SessionDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SessionDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionDate[]    findAll()
 * @method SessionDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionDate::class);
    }

    public function deleteDates(SessionDate $dateSession)
    {
        $insertSessionAndDateAndSessionCustomer = $this->getEntityManager()->getConnection()->prepare("DELETE FROM session_date WHERE ID = :id");
        $insertSessionAndDateAndSessionCustomer->bindValue(':id', $dateSession->getId());
        $insertSessionAndDateAndSessionCustomer->executeQuery();
    }

    // /**
    //  * @return SessionDate[] Returns an array of SessionDate objects
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
    public function findOneBySomeField($value): ?SessionDate
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
