<?php

namespace App\Controller;

use App\Entity\ActionTrainee;
use App\Form\ActionTraineeType;
use App\Repository\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actiontrainee')]
class ActionTraineeController extends AbstractController
{
    #[Route('/', name: 'action_trainee_index', methods: ['GET'])]
    public function index(ActionRepository $actionRepository): Response
    {
        return $this->render('action_trainee/index.html.twig', [
            'action_trainees' => $actionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'action_trainee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actionTrainee = new ActionTrainee();
        $form = $this->createForm(ActionTraineeType::class, $actionTrainee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actionTrainee);
            $entityManager->flush();

            return $this->redirectToRoute('action_trainee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('action_trainee/new.html.twig', [
            'action_trainee' => $actionTrainee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'action_trainee_show', methods: ['GET'])]
    public function show(ActionTrainee $actionTrainee): Response
    {
        return $this->render('action_trainee/show.html.twig', [
            'action_trainee' => $actionTrainee,
        ]);
    }

    #[Route('/{id}/edit', name: 'action_trainee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActionTrainee $actionTrainee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActionTraineeType::class, $actionTrainee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('action_trainee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('action_trainee/edit.html.twig', [
            'action_trainee' => $actionTrainee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'action_trainee_delete', methods: ['POST'])]
    public function delete(Request $request, ActionTrainee $actionTrainee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actionTrainee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actionTrainee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('action_trainee_index', [], Response::HTTP_SEE_OTHER);
    }
}
