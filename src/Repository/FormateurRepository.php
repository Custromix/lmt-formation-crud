<?php

namespace App\Repository;

use App\Entity\Formateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formateur[]    findAll()
 * @method Formateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formateur::class);
    }

    public function getTrainerBySkills(int $idTrainaing)
    {
        $selectTrainerBySkills = $this->getEntityManager()->getConnection()->prepare(
            "SELECT DISTINCT F.ID, F.NAME, F.FIRSTNAME
                FROM Formateur F
                INNER JOIN to_know T ON F.id = T.trainer_id
                INNER JOIN skills S ON T.skills_id = S.skills_id
                INNER JOIN training_type_skills TRAINSKILL ON S.skills_id = TRAINSKILL.skills_id
                INNER JOIN training_type TRAINTYPE ON TRAINSKILL.training_type_id = TRAINTYPE.id
                INNER JOIN formation_type_formation TRAINTYPETRAIN ON TRAINTYPE.id = TRAINTYPETRAIN.type_formation_id
                INNER JOIN standard_training ST ON TRAINTYPETRAIN.formation_id = 1");
        dd(json_encode($selectTrainerBySkills->executeQuery()->fetchAssociative()));
    }

    // /**
    //  * @return Formateur[] Returns an array of Formateur objects
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
    public function findOneBySomeField($value): ?Formateur
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
