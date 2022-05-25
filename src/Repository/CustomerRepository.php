<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function addCustomerAndContact($customer)
    {
        $insertContact = '';
        for ($i = 0; $i < count($customer->getContacts()); $i++) {
            $insertContact = $insertContact . "INSERT INTO contact (CONTACT_TYPE_ID, CUSTOMER_ID, CIVILITY, NAME, FIRSTNAME, MAIL, MOBILE_PHONE, LANDLINE_PHONE)
            VALUES (:idContactType$i, @id, :civilty$i, :name$i, :firstname$i, :mail$i, :mobilePhone$i, :landlinePhone$i);";
        }

        $insertCustomerAndContactsQuery = "
                                    START TRANSACTION;
                                    INSERT INTO customer (COMPANY_TYPE_ID, NAME, FIRSTNAME, WEBSITE, ADDRESS, CITY, POSTAL)
                                    VALUES (:idCompanyType, :name, :firstname, :website, :address, :city, :postal);
                                    SELECT LAST_INSERT_ID() into @id;
                                    " . $insertContact . "
                                    COMMIT;
                                    ";
        $insertCustomerAndContacts = $this->getEntityManager()->getConnection()->prepare($insertCustomerAndContactsQuery);
        $insertCustomerAndContacts->bindValue(':idCompanyType', $customer->getCompanyType()->getId());
        $insertCustomerAndContacts->bindValue(':name', $customer->getName());
        $insertCustomerAndContacts->bindValue(':firstname', $customer->getFirstname());
        $insertCustomerAndContacts->bindValue(':website', $customer->getWebsite());
        $insertCustomerAndContacts->bindValue(':address', $customer->getAddress());
        $insertCustomerAndContacts->bindValue(':city', $customer->getCity());
        $insertCustomerAndContacts->bindValue(':postal', $customer->getPostal());

        for ($i = 0; $i < count($customer->getContacts()); $i++) {
            $insertCustomerAndContacts->bindValue(":idContactType$i", $customer->getContacts()[$i]->getContactType()->getId());
            $insertCustomerAndContacts->bindValue(":civilty$i", $customer->getContacts()[$i]->getCivility());
            $insertCustomerAndContacts->bindValue(":name$i", $customer->getContacts()[$i]->getName());
            $insertCustomerAndContacts->bindValue(":firstname$i", $customer->getContacts()[$i]->getFirstname());
            $insertCustomerAndContacts->bindValue(":mail$i", $customer->getContacts()[$i]->getMail());
            $insertCustomerAndContacts->bindValue(":mobilePhone$i", $customer->getContacts()[$i]->getMobilePhone());
            $insertCustomerAndContacts->bindValue(":landlinePhone$i", $customer->getContacts()[$i]->getLandlinePhone());
        }

        $insertCustomerAndContacts->executeQuery();
    }

    public function updateCustomerAndContact($customer)
    {
        $updateContact = "";
        $insertContact = "";

        for ($i = 0; $i < count($customer->getContacts()); $i++) {
            if (!empty($customer->getContacts()[$i]->getId())) {
                $updateContact = $updateContact .
                    "UPDATE contact
                    SET CONTACT_TYPE_ID = :idContactType$i,
                    CUSTOMER_ID = :idCustomer$i,
                    CIVILITY = :civilty$i,
                    NAME = :name$i,
                    FIRSTNAME = :firstname$i,
                    MAIL = :mail$i,
                    MOBILE_PHONE = :mobilePhone$i,
                    LANDLINE_PHONE = :landlinePhone$i
                    WHERE ID = :idContact$i;";
            }else{
                $insertContact = $insertContact . "INSERT INTO contact (CONTACT_TYPE_ID, CUSTOMER_ID, CIVILITY, NAME, FIRSTNAME, MAIL, MOBILE_PHONE, LANDLINE_PHONE)
                                                    VALUES (:idContactType$i, :idCustomer$i, :civilty$i, :name$i, :firstname$i, :mail$i, :mobilePhone$i, :landlinePhone$i);";
            }

        }

        $insertCustomerAndContactsQuery = "
                                    START TRANSACTION;
                                    UPDATE customer
                                    SET COMPANY_TYPE_ID = :idCompanyType,
                                    NAME = :name,
                                    FIRSTNAME = :firstname,
                                    WEBSITE = :website,
                                    ADDRESS = :address,
                                    CITY = :city,
                                    POSTAL = :postal
                                    WHERE ID = :idUser;
                                    " . $updateContact . "
                                    " . $insertContact . "
                                    COMMIT;
                                    ";
        $insertCustomerAndContacts = $this->getEntityManager()->getConnection()->prepare($insertCustomerAndContactsQuery);
        $insertCustomerAndContacts->bindValue(':idCompanyType', $customer->getCompanyType()->getId());
        $insertCustomerAndContacts->bindValue(':name', $customer->getName());
        $insertCustomerAndContacts->bindValue(':firstname', $customer->getFirstname());
        $insertCustomerAndContacts->bindValue(':website', $customer->getWebsite());
        $insertCustomerAndContacts->bindValue(':address', $customer->getAddress());
        $insertCustomerAndContacts->bindValue(':city', $customer->getCity());
        $insertCustomerAndContacts->bindValue(':postal', $customer->getPostal());
        $insertCustomerAndContacts->bindValue(':idUser', $customer->getId());


        for ($i = 0; $i < count($customer->getContacts()); $i++) {
            $insertCustomerAndContacts->bindValue(":idContactType$i", $customer->getContacts()[$i]->getContactType()->getId());
            $insertCustomerAndContacts->bindValue(":idCustomer$i", $customer->getId());
            $insertCustomerAndContacts->bindValue(":civilty$i", $customer->getContacts()[$i]->getCivility());
            $insertCustomerAndContacts->bindValue(":name$i", $customer->getContacts()[$i]->getName());
            $insertCustomerAndContacts->bindValue(":firstname$i", $customer->getContacts()[$i]->getFirstname());
            $insertCustomerAndContacts->bindValue(":mail$i", $customer->getContacts()[$i]->getMail());
            $insertCustomerAndContacts->bindValue(":mobilePhone$i", $customer->getContacts()[$i]->getMobilePhone());
            $insertCustomerAndContacts->bindValue(":landlinePhone$i", $customer->getContacts()[$i]->getLandlinePhone());
            if(!empty($customer->getContacts()[$i]->getId())){
                $insertCustomerAndContacts->bindValue(":idContact$i", $customer->getContacts()[$i]->getId());
            }
        }

        $insertCustomerAndContacts->executeQuery();
    }

    // /**
    //  * @return Customer[] Returns an array of Customer objects
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
    public function findOneBySomeField($value): ?Customer
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
