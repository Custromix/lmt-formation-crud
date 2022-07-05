<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * Requête permettant l'ajout d'une session et de ses relation avec les tables session_date, customer & bePaid
     * @param Session objet session de la table session contenant toutes les informations de la table et de ses relations
     */
    public function addSessionAndDateAndCustomerAndBePaid($session)
    {
        $insertSessionDate = null;
        $insertSessionCustomer = null;
        $insertBePaid = null;

        for($i = 0; $i < count($session->getSessionDate()); $i++) {
            $insertSessionDate = $insertSessionDate . "INSERT INTO session_date (SESSION_ID, DAY, DATE_FORMATION)
                                            VALUES (@idSession, :day$i, :dateFormation$i);";
        }

        for($i = 0; $i < count($session->getCustomer()); $i++) {
            $insertSessionCustomer = $insertSessionCustomer . "INSERT INTO session_customer (SESSION_ID, CUSTOMER_ID)
                                            VALUES (@idSession, :idCustomer$i);";
        }

        for ($i = 0; $i < count($session->getBePaids()); $i++){
            $insertBePaid = $insertBePaid . "INSERT INTO be_paid (FINANCING_TYPE_ID, SESSION_ID)
                                            VALUES (:idFinancing$i, @idSession);";
        }

        $insertSessionAndDateAndSessionCustomerQuery = "
                                    START TRANSACTION;
                                    INSERT INTO to_do_list VALUES();
                                    SELECT LAST_INSERT_ID() into @idToDoList;
                                    INSERT INTO session (trainer_id, status_id, to_do_list_id, standard_training_id, place, nb_trainee, estimate_price, note)
                                    VALUES (:trainer_id, :status_id, @idToDoList, :standard_training_id, :place, :nb_trainee, :estimate_price, :note);
                                    SELECT LAST_INSERT_ID() into @idSession;
                                    ".$insertSessionDate."
                                    ".$insertSessionCustomer."
                                    ".$insertBePaid."
                                    COMMIT;
                                    ";
        $insertSessionAndDateAndSessionCustomer = $this->getEntityManager()->getConnection()->prepare($insertSessionAndDateAndSessionCustomerQuery);
        $insertSessionAndDateAndSessionCustomer->bindValue(':trainer_id', $session->getTrainer()->getId()?:null);
        $insertSessionAndDateAndSessionCustomer->bindValue(':status_id', $session->getStatus()->getId()?:null);
        $insertSessionAndDateAndSessionCustomer->bindValue(':standard_training_id', $session->getStandardTraining()->getId()?:null);
        //        $insertSessionAndDateAndSessionCustomer->bindValue(':customize_training_id', $session->getCustomizeTraining()->getId());
        $insertSessionAndDateAndSessionCustomer->bindValue(':place', $session->getPlace());
        $insertSessionAndDateAndSessionCustomer->bindValue(':nb_trainee', $session->getNbTrainee());
        $insertSessionAndDateAndSessionCustomer->bindValue(':estimate_price', $session->getEstimatePrice());
        $insertSessionAndDateAndSessionCustomer->bindValue(':note', $session->getNote());

        for($i = 0; $i < count($session->getSessionDate()); $i++) {
            $insertSessionAndDateAndSessionCustomer->bindValue(":day$i", $session->getSessionDate()[$i]->getDay());
            $insertSessionAndDateAndSessionCustomer->bindValue(":dateFormation$i", $session->getSessionDate()[$i]->getDateFormation());
        }

        for($i = 0; $i < count($session->getCustomer()); $i++) {
            $insertSessionAndDateAndSessionCustomer->bindValue(":idCustomer$i", $session->getCustomer()[$i]->getId());
        }

        for ($i = 0; $i < count($session->getBePaids()); $i++){
            $insertSessionAndDateAndSessionCustomer->bindValue(":idFinancing$i", $session->getBePaids()[$i]->getFinancingType()->getId()?:null);
        }

        $insertSessionAndDateAndSessionCustomer->executeQuery();
    }

    /**
     * Requête permettant la modification d'une session et de ses relation avec les tables session_date, customer & bePaid
     * @param Session objet session de la table session contenant toutes les informations de la table et de ses relations
     */
    public function updateSessionAndCustomerAndDateAndFinancingType(Session $session)
    {
        $updateSessionDate = null;
        $newSessionDate = null;

        $updateBePaid = null;
        $newBePaid = null;

        $insertSessionCustomer = null;

        for ($i = 0; $i < count($session->getSessionDate()); $i++){
            if (!empty($session->getSessionDate()[$i]->getId())){
                $updateSessionDate = $updateSessionDate .
                    "UPDATE session_date
                    SET SESSION_ID = :idSessionDate$i,
                        DAY = :day$i,
                        DATE_FORMATION = :dateFormation$i
                    WHERE ID = :idDate$i;"
                ;
            }else{
                $newSessionDate = $newSessionDate .
                    "INSERT INTO session_date (SESSION_ID, DAY, DATE_FORMATION)
                                            VALUES (:idSessionDate$i, :day$i, :dateFormation$i);"
                    ;
            }
        }


        for ($i = 0; $i < count($session->getBePaids()); $i++){
            if (!empty($session->getBePaids()[$i]->getFinancingType()->getOldId())){
                $updateBePaid = $updateBePaid .
                    "UPDATE be_paid
                    SET FINANCING_TYPE_ID = :idFinancingType$i
                    WHERE FINANCING_TYPE_ID = :idOldFinancingType$i AND SESSION_ID = :idSessionBePaid$i;"
                ;
            }else{
                $newBePaid = $newBePaid .
                    "INSERT INTO be_paid (FINANCING_TYPE_ID, SESSION_ID)
                                            VALUES (:idFinancingType$i, :idSessionBePaid$i);"
                ;
            }
        }

        for($i = 0; $i < count($session->getCustomer()); $i++) {
            $insertSessionCustomer = $insertSessionCustomer .
                "INSERT INTO session_customer (SESSION_ID, CUSTOMER_ID)
                                            VALUES (:idSessionCustomer$i, :idCustomer$i);";
        }

        $updateSessionAndDateAndSessionCustomerQuery = "
                                    START TRANSACTION;
                                    UPDATE session
                                    SET TRAINER_ID = :trainer_id,
                                        STATUS_ID = :status_id,
                                        STANDARD_TRAINING_ID = :standard_training_id,
                                        PLACE = :place,
                                        NB_TRAINEE = :nb_trainee,
                                        ESTIMATE_PRICE = :estimate_price,
                                        PURCHASE_ORDER = :purchase_order,
                                        NOTE = :note
                                    WHERE ID = :idSession;
                                    DELETE FROM session_customer
                                    WHERE session_id = :idSession1;
                                    ".$updateSessionDate."
                                    ".$newSessionDate."
                                    ".$updateBePaid."
                                    ".$newBePaid."
                                    ".$insertSessionCustomer."
                                    COMMIT;
                                    ";

        $updateSessionAndDateAndSessionCustomer = $this->getEntityManager()->getConnection()->prepare($updateSessionAndDateAndSessionCustomerQuery);
        $updateSessionAndDateAndSessionCustomer->bindValue(':idSession', $session->getId());
        $updateSessionAndDateAndSessionCustomer->bindValue(':idSession1', $session->getId());
        $updateSessionAndDateAndSessionCustomer->bindValue(':trainer_id', $session->getTrainer()->getId()?: null);
        $updateSessionAndDateAndSessionCustomer->bindValue(':status_id', $session->getStatus()->getId() ?: null);
        $updateSessionAndDateAndSessionCustomer->bindValue(':standard_training_id', $session->getStandardTraining()->getId() ?: null);
        $updateSessionAndDateAndSessionCustomer->bindValue(':place', $session->getPlace());
        $updateSessionAndDateAndSessionCustomer->bindValue(':nb_trainee', $session->getNbTrainee());
        $updateSessionAndDateAndSessionCustomer->bindValue(':estimate_price', $session->getEstimatePrice());
        $updateSessionAndDateAndSessionCustomer->bindValue(':purchase_order', $session->getPurchaseOrder());
        $updateSessionAndDateAndSessionCustomer->bindValue(':note', $session->getNote());

        for($i = 0; $i < count($session->getSessionDate()); $i++) {
            $updateSessionAndDateAndSessionCustomer->bindValue(":idSessionDate$i", $session->getId());
            $updateSessionAndDateAndSessionCustomer->bindValue(":day$i", $session->getSessionDate()[$i]->getDay());
            $updateSessionAndDateAndSessionCustomer->bindValue(":dateFormation$i", $session->getSessionDate()[$i]->getDateFormation());
            if (!empty($session->getSessionDate()[$i]->getId())){
                $updateSessionAndDateAndSessionCustomer->bindValue(":idDate$i", $session->getSessionDate()[$i]->getId());
            }
        }

        for($i = 0; $i < count($session->getBePaids()); $i++) {
            $updateSessionAndDateAndSessionCustomer->bindValue(":idFinancingType$i", $session->getBePaids()[$i]->getFinancingType()->getId());
            $updateSessionAndDateAndSessionCustomer->bindValue(":idSessionBePaid$i", $session->getId());
            if (!empty($session->getBePaids()[$i]->getFinancingType()->getOldId())){
                $updateSessionAndDateAndSessionCustomer->bindValue(":idOldFinancingType$i", $session->getBePaids()[$i]->getFinancingType()->getOldId());
            }
        }

        for($i = 0; $i < count($session->getCustomer()); $i++) {
            $updateSessionAndDateAndSessionCustomer->bindValue(":idSessionCustomer$i", $session->getId());
            $updateSessionAndDateAndSessionCustomer->bindValue(":idCustomer$i", $session->getCustomer()[$i]->getId());
        }

        $updateSessionAndDateAndSessionCustomer->executeQuery();
    }


     /**
      * @return int Returns last insert id from Session
      */
    public function lastInsertId()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()[0]
        ;
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
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
    public function findOneBySomeField($value): ?Session
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
