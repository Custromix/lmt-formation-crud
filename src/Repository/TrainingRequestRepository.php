<?php

namespace App\Repository;

use App\Entity\TrainingRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingRequest[]    findAll()
 * @method TrainingRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingRequest::class);
    }

    public function addTrainingRequestAndTrainings(TrainingRequest $trainingRequest)
    {
        $insertSTTR = '';

        for ($i = 0; $i < count($trainingRequest->getStandardTrainings()); $i++) {
            $insertSTTR = $insertSTTR . "INSERT INTO standard_training_training_request (STANDARD_TRAINING_ID, TRAINING_REQUEST_ID)
            VALUES (:idStandardTraining$i, @idTrainingRequest);";
        }

        $insertCustomerAndContactsQuery = "
                                    START TRANSACTION;
                                    INSERT INTO training_request (CUSTOMER_ID, NAME, FIRSTNAME, MAIL, PHONE, DATE_REQUEST, NOTE)
                                    VALUES (:id_customer, :name, :firstname, :mail, :phone, :date_request, :note);
                                    SELECT LAST_INSERT_ID() into @idTrainingRequest;
                                    " . $insertSTTR . "
                                    COMMIT;
                                    ";
        $insertCustomerAndContacts = $this->getEntityManager()->getConnection()->prepare($insertCustomerAndContactsQuery);
        $insertCustomerAndContacts->bindValue(':id_customer', $trainingRequest->getCustomer()->getId()?:null);
        $insertCustomerAndContacts->bindValue(':name', $trainingRequest->getName());
        $insertCustomerAndContacts->bindValue(':firstname', $trainingRequest->getFirstname());
        $insertCustomerAndContacts->bindValue(':mail', $trainingRequest->getMail());
        $insertCustomerAndContacts->bindValue(':phone', $trainingRequest->getPhone());
        $insertCustomerAndContacts->bindValue(':date_request', $trainingRequest->getDateRequest());
        $insertCustomerAndContacts->bindValue(':note', $trainingRequest->getNote());

        for ($i = 0; $i < count($trainingRequest->getStandardTrainings()); $i++) {
            $insertCustomerAndContacts->bindValue(":idStandardTraining$i", $trainingRequest->getStandardTrainings()[$i]->getId());
        }

        $insertCustomerAndContacts->executeQuery();
    }

    public function updateTrainingRequestAndTrainings(TrainingRequest $trainingRequest)
    {
        $insertSTTR = '';

        for ($i = 0; $i < count($trainingRequest->getStandardTrainings()); $i++) {
            $insertSTTR = $insertSTTR . "INSERT INTO standard_training_training_request (STANDARD_TRAINING_ID, TRAINING_REQUEST_ID)
            VALUES (:idStandardTraining$i, :idTrainingRequestInsertSTTR$i);";
        }

        $insertCustomerAndContactsQuery = "
                                    START TRANSACTION;
                                    UPDATE training_request
                                    SET CUSTOMER_ID = :id_customer, 
                                        NAME = :name, 
                                        FIRSTNAME = :firstname, 
                                        MAIL = :mail, 
                                        PHONE = :phone, 
                                        DATE_REQUEST = :date_request, 
                                        NOTE = :note
                                    WHERE ID = :idTrainingRequestUpdate;
                                    DELETE FROM standard_training_training_request WHERE TRAINING_REQUEST_ID = :idTrainingRequestDelete;
                                    " . $insertSTTR . "
                                    COMMIT;
                                    ";
        $insertCustomerAndContacts = $this->getEntityManager()->getConnection()->prepare($insertCustomerAndContactsQuery);
        $insertCustomerAndContacts->bindValue(':idTrainingRequestUpdate', $trainingRequest->getId());
        $insertCustomerAndContacts->bindValue(':id_customer', $trainingRequest->getCustomer()->getId()?:null);
        $insertCustomerAndContacts->bindValue(':name', $trainingRequest->getName());
        $insertCustomerAndContacts->bindValue(':firstname', $trainingRequest->getFirstname());
        $insertCustomerAndContacts->bindValue(':mail', $trainingRequest->getMail());
        $insertCustomerAndContacts->bindValue(':phone', $trainingRequest->getPhone());
        $insertCustomerAndContacts->bindValue(':date_request', $trainingRequest->getDateRequest());
        $insertCustomerAndContacts->bindValue(':note', $trainingRequest->getNote());
        $insertCustomerAndContacts->bindValue(':idTrainingRequestDelete', $trainingRequest->getId());

        for ($i = 0; $i < count($trainingRequest->getStandardTrainings()); $i++) {
            $insertCustomerAndContacts->bindValue(":idStandardTraining$i", $trainingRequest->getStandardTrainings()[$i]->getId());
            $insertCustomerAndContacts->bindValue(":idTrainingRequestInsertSTTR$i", $trainingRequest->getId());
        }

        $insertCustomerAndContacts->executeQuery();
    }

    // /**
    //  * @return TrainingRequest[] Returns an array of TrainingRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrainingRequest
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
