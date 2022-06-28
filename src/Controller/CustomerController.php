<?php

namespace App\Controller;

use App\Entity\CompanyType;
use App\Entity\ContactType;
use App\Entity\Contact;
use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;


/**
 * @Route("/customer")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/", name="customer_index", methods={"GET"})
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('customer/index.html.twig', [
            'customers' => $customerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="customer_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        if (!empty($_POST['customer'])) {
            $customer = new Customer();
            $fsObject = new Filesystem();
            $customer->init($_POST['customer']);

            if (!empty($_POST['form'][0]['name'])) {
                foreach ($_POST['form'] as $aContact) {
                    $contact = new Contact($aContact['civility'], $aContact['contactType'], $aContact['name'], $aContact['firstname'], $aContact['mail'], $aContact['mobile'], $aContact['fixe']);
                    $customer->addContact($contact);
                }
            }
            $entityManager->getRepository(Customer::class)->addCustomerAndContact($customer);
            $fsObject->mkdir('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Session/' . $customer->getName());
            return $this->redirectToRoute('customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customer/new.html.twig', [
            'companyTypes' => $entityManager->getRepository(CompanyType::class)->findAll(),
            'contactTypes' => $entityManager->getRepository(ContactType::class)->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="customer_show", methods={"GET"})
     */
    public function show(Customer $customer): Response
    {
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Customer $thisCustomer, EntityManagerInterface $entityManager): Response
    {
        if (!empty($_POST['customer'])) {
            $customer = new Customer();
            $customer->setId($thisCustomer->getId());
            $customer->init($_POST['customer']);

            if (!empty($_POST['form'])) {
                foreach ($_POST['form'] as $formContact){
                    if ($formContact['status'] == "new"){
                        $contact = new Contact($formContact['civility'], $formContact['contactType'], $formContact['name'], $formContact['firstname'], $formContact['mail'], $formContact['mobile'], $formContact['fixe']);
                        $customer->addContact($contact);
                    }elseif ($formContact['status'] == "edit"){
                        $contact = new Contact($formContact['civility'], $formContact['contactType'], $formContact['name'], $formContact['firstname'], $formContact['mail'], $formContact['mobile'], $formContact['fixe']);
                        $contact->setId($formContact['id']);
                        $customer->addContact($contact);
                    }else{
                        $contact = new Contact($formContact['civility'], $formContact['contactType'], $formContact['name'], $formContact['firstname'], $formContact['mail'], $formContact['mobile'], $formContact['fixe']);
                        $contact->setId($formContact['id']);
                        $entityManager->getRepository(Contact::class)->deleteContacts($contact);
                        $customer->removeContact($contact);
                    }
                }
            }

            $entityManager->getRepository(Customer::class)->updateCustomerAndContact($customer);
            return $this->redirectToRoute('customer_edit', ["id" => $customer->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customer/edit.html.twig', [
            'customer' => $thisCustomer,
            'companyTypes' => $entityManager->getRepository(CompanyType::class)->findAll(),
            'contactTypes' => $entityManager->getRepository(ContactType::class)->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods={"POST"})
     */
    public function delete(Request $request, Customer $customer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_index', [], Response::HTTP_SEE_OTHER);
    }
}
