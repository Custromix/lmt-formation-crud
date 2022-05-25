<?php

namespace App\Controller;

use App\Entity\StandardTraining;
use App\Form\StandardTrainingType;
use App\Repository\StandardTrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/standardtraining")
 */
class StandardTrainingController extends AbstractController
{
    /**
     * @Route("/", name="standard_training_index", methods={"GET"})
     */
    public function index(StandardTrainingRepository $standardTrainingRepository): Response
    {
        return $this->render('standard_training/index.html.twig', [
            'standard_trainings' => $standardTrainingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="standard_training_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $standardTraining = new StandardTraining();
        $form = $this->createForm(StandardTrainingType::class, $standardTraining);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($standardTraining);
            $entityManager->flush();

            return $this->redirectToRoute('standard_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('standard_training/new.html.twig', [
            'standard_training' => $standardTraining,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="standard_training_show", methods={"GET"})
     */
    public function show(StandardTraining $standardTraining): Response
    {
        return $this->render('standard_training/show.html.twig', [
            'standard_training' => $standardTraining,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="standard_training_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, StandardTraining $standardTraining, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StandardTrainingType::class, $standardTraining);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('standard_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('standard_training/edit.html.twig', [
            'standard_training' => $standardTraining,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="standard_training_delete", methods={"POST"})
     */
    public function delete(Request $request, StandardTraining $standardTraining, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$standardTraining->getId(), $request->request->get('_token'))) {
            $entityManager->remove($standardTraining);
            $entityManager->flush();
        }

        return $this->redirectToRoute('standard_training_index', [], Response::HTTP_SEE_OTHER);
    }
}
