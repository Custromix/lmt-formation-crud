<?php

namespace App\Controller;

use App\Entity\BePaid;
use App\Entity\Contact;
use App\Entity\Customer;
use App\Entity\FinancingType;
use App\Entity\Formateur;
use App\Entity\Session;
use App\Entity\SessionDate;
use App\Entity\StandardTraining;
use App\Entity\Status;
use App\Entity\TrainingType;
use App\Form\Session1Type;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!empty($_POST['session'])) {
            $session = new Session();
            $fsObject = new Filesystem();
            $session->init($_POST['session']);

            if (!empty($_POST['customer'])){
                foreach ($_POST['customer'] as $customerId){
                    $aCustomer = $entityManager->getRepository(Customer::class)->find($customerId);
                    $session->addCustomer($aCustomer);
                }
            }

            if (!empty($_POST['financingType'])){
                foreach ($_POST['financingType'] as $financingType){
                    $aFinancingType = new FinancingType();
                    $aFinancingType->setId(intval($financingType));
                    $aBePaid = new BePaid($aFinancingType, $session);
                    $session->addBePaid($aBePaid);
                }
            }

            if (!empty($_POST['dateSession'])){
                $count = 0;
                foreach ($_POST['dateSession'] as $date){
                    $aSessionDate = new SessionDate("JOUR_".$count, $date, $session);
                    $count++;
                    $session->addSessionDate($aSessionDate);
                }
            }
            $entityManager->getRepository(Session::class)->addSessionAndDateAndCustomerAndBePaid($session);
            $idSession = $entityManager->getRepository(Session::class)->lastInsertId()['id'];
            $fsObject->mkdir('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Session/' . $session->getCustomer()[0]->getName() . '/'.$session->getSessionDate()[0]->getDateFormation().'_'.$entityManager->getRepository(StandardTraining::class)->find($session->getStandardTraining()->getId())->getReference().'_'. $idSession .'_'.$entityManager->getRepository(Status::class)->find($session->getStatus()->getId())->getName().'/');
            return $this->redirectToRoute('session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/new.html.twig', [
            'customers' => $entityManager->getRepository(Customer::class)->findAll(),
            'trainings' => $entityManager->getRepository(StandardTraining::class)->findAll(),
            'trainingTypes' => $entityManager->getRepository(TrainingType::class)->findAll(),
            'financingTypes' => $entityManager->getRepository(FinancingType::class)->findAll(),
            'status' => $entityManager->getRepository(Status::class)->findAll(),
            'formateurs' => $entityManager->getRepository(Formateur::class)->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $thisSession, EntityManagerInterface $entityManager): Response
    {
        if (!empty($_POST['session'])) {
            $session = new Session();
            $session->setId($thisSession->getId());
            $session->init($_POST['session']);

            if (!empty($_POST['customer'])){
                foreach ($_POST['customer'] as $customerId){
                    $aCustomer = new Customer();
                    $aCustomer->setId($customerId);
                    $session->addCustomer($aCustomer);
                }
            }

            if (!empty($_POST['financingType'])){
                foreach ($_POST['financingType'] as $financingTypeForm){
                    if ($financingTypeForm['status'] == "new"){
                        $aFinancingType = new FinancingType();
                        $aFinancingType->setId(intval($financingTypeForm["id"]));

                        $aBePaid = new BePaid($aFinancingType, $session);

                        $session->addBePaid($aBePaid);

                    }elseif ($financingTypeForm['status'] == "edit"){
                        $aFinancingType = new FinancingType();
                        $aFinancingType->setId(intval($financingTypeForm["id"]));
                        $aFinancingType->setOldId(intval($financingTypeForm["oldFinancingTypeId"]));

                        $aBePaid = new BePaid($aFinancingType, $session);

                        $session->addBePaid($aBePaid);
                    }else{
                        $aFinancingType = new FinancingType();
                        $aFinancingType->setId(intval($financingTypeForm["id"]));
                        $aFinancingType->setOldId(intval($financingTypeForm["oldFinancingTypeId"]));
                        $aBePaid = new BePaid($aFinancingType, $session);
                        $entityManager->getRepository(BePaid::class)->deleteBePaid($aBePaid);
                    }
                }
            }



            if (!empty($_POST['dateSession'])) {
                $count = 1;
                foreach ($_POST['dateSession'] as $sessionDateForm){
                    if ($sessionDateForm['status'] == "new"){
                        $sessionDate = new SessionDate("JOUR_".$count, $sessionDateForm["date"], $session);
                        $session->addSessionDate($sessionDate);

                    }elseif ($sessionDateForm['status'] == "edit"){
                        $sessionDate = new SessionDate("JOUR_".$count, $sessionDateForm["date"], $session);
                        $sessionDate->setId($sessionDateForm['id']);
                        $session->addSessionDate($sessionDate);

                    }else{
                        $sessionDate = new SessionDate("JOUR_".$count, $sessionDateForm["date"], $session);
                        $sessionDate->setId($sessionDateForm['id']);
                        $entityManager->getRepository(SessionDate::class)->deleteDates($sessionDate);
                        $session->removeSessionDate($sessionDate);
                    }
                    $count++;
                }
            }

            $entityManager->getRepository(Session::class)->updateSessionAndCustomerAndDateAndFinancingType($session);
            return $this->redirectToRoute('session_edit', ["id" => $session->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('session/edit.html.twig', [
            'session' => $thisSession,
            'customers' => $entityManager->getRepository(Customer::class)->findAll(),
            'trainings' => $entityManager->getRepository(StandardTraining::class)->findAll(),
            'financingTypes' => $entityManager->getRepository(FinancingType::class)->findAll(),
            'status' => $entityManager->getRepository(Status::class)->findAll(),
            'formateurs' => $entityManager->getRepository(Formateur::class)->findAll()
        ]);
    }

    #[Route('/{id}', name: 'session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('session_index', [], Response::HTTP_SEE_OTHER);
    }
}
