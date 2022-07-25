<?php

namespace App\Controller;

use App\Entity\ActionTrainee;
use App\Entity\Contact;
use App\Entity\Customer;
use App\Entity\StandardTraining;
use App\Entity\TrainingRequest;
use App\Form\TrainingRequestType;
use App\Repository\TrainingRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trainingrequest')]
class TrainingRequestController extends AbstractController
{
    #[Route('/', name: 'training_request_index', methods: ['GET'])]
    public function index(TrainingRequestRepository $trainingRequestRepository): Response
    {
        $allTrainingRequest = $trainingRequestRepository->findAll();

        for ($i = 0; $i < count($allTrainingRequest); $i++){
            $allTrainingRequest[$i]->setColor();
        }
        
        return $this->render('training_request/index.html.twig', [
            'training_requests' => $allTrainingRequest,
        ]);
    }

    #[Route('/new', name: 'training_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        if (!empty($_POST['trainingRequest'])) {
            $trainingRequest = new TrainingRequest();
            $trainingRequest->init($_POST['trainingRequest']);
            $thisAction = $entityManager->getRepository(ActionTrainee::class)->find($_POST['trainingRequest']['idAction']);
            $trainingRequest->setAction($thisAction);

            if (!empty($_POST['trainingRequest']['training'])) {
                foreach ($_POST['trainingRequest']['training'] as $aTrainingForm) {
                    $training = new StandardTraining();
                    $training->setId(intval($aTrainingForm['id']));
                    $trainingRequest->addStandardTraining($training);
                }
            }

            $entityManager->getRepository(TrainingRequest::class)->addTrainingRequestAndTrainings($trainingRequest);
            return $this->redirectToRoute('training_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('training_request/new.html.twig', [
            'trainings' => $entityManager->getRepository(StandardTraining::class)->findAll(),
            'customers' => $entityManager->getRepository(Customer::class)->findAll(),
            'actionTrainee' => $entityManager->getRepository(ActionTrainee::class)->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'training_request_show', methods: ['GET'])]
    public function show(TrainingRequest $trainingRequest): Response
    {
        return $this->render('training_request/show.html.twig', [
            'training_request' => $trainingRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'training_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingRequest $thisTrainingRequest, EntityManagerInterface $entityManager): Response
    {
        if (!empty($_POST['trainingRequest']['training'])) {
            $trainingRequest = new TrainingRequest();
            $trainingRequest->init($_POST['trainingRequest']);
            $trainingRequest->setId($thisTrainingRequest->getId());
            $thisAction = $entityManager->getRepository(ActionTrainee::class)->find($_POST['trainingRequest']['idAction']);
            $trainingRequest->setAction($thisAction);

            if (!empty($_POST['trainingRequest']['training'])) {
                foreach ($_POST['trainingRequest']['training'] as $aTrainingForm) {
                    $training = new StandardTraining();
                    $training->setId(intval($aTrainingForm['id']));
                    $trainingRequest->addStandardTraining($training);
                }
            }

            $entityManager->getRepository(TrainingRequest::class)->updateTrainingRequestAndTrainings($trainingRequest);
            return $this->redirectToRoute('training_request_edit', ['id' => $thisTrainingRequest->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('training_request/edit.html.twig', [
            'trainingRequest' => $thisTrainingRequest,
            'trainings' => $entityManager->getRepository(StandardTraining::class)->findAll(),
            'customers' => $entityManager->getRepository(Customer::class)->findAll(),
            'actionTrainee' => $entityManager->getRepository(ActionTrainee::class)->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'training_request_delete', methods: ['POST'])]
    public function delete(Request $request, TrainingRequest $trainingRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingRequest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trainingRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('training_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
