<?php

namespace App\Controller;

use App\Entity\ToDoList;
use App\Form\ToDoListType;
use App\Repository\ToDoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

#[Route('/todolist')]
class ToDoListController extends AbstractController
{
    #[Route('/', name: 'to_do_list_index', methods: ['GET'])]
    public function index(ToDoListRepository $toDoListRepository): Response
    {
        return $this->render('to_do_list/index.html.twig', [
            'to_do_lists' => $toDoListRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'to_do_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $toDoList = new ToDoList();
        $form = $this->createForm(ToDoListType::class, $toDoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($toDoList);
            $entityManager->flush();

            return $this->redirectToRoute('to_do_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('to_do_list/new.html.twig', [
            'to_do_list' => $toDoList,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/{name}/download", name="to_do_list_download", methods={"GET"})
     */
    public function download(string $name, ToDoList $toDoList): Response
    {
        if (is_dir('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Document/'.$name)){
            $finder = new Finder();
            $files = $finder->files()->in('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Document/'.$name);

            /*
            $fsObject = new Filesystem();
            if ($fsObject->exists('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Session/'. $toDoList->getSession()->getCustomer()[0]->getName()))
            {
                $fsObject->mkdir($new_dir_path, 0775);
                $fsObject->chown($new_dir_path, "www-data");
                $fsObject->chgrp($new_dir_path, "www-data");
                umask($old);
            }*/

            $filesName = [];
            foreach ($files as $file)
            {
                array_push($filesName, $file->getRelativePathname());
            }
        }

        return $this->renderForm('to_do_list/file.html.twig', [
            'to_do_list' => $toDoList,
            'filesName' => $filesName,
        ]);
    }

    #[Route('/{id}/edit', name: 'to_do_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ToDoList $toDoList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToDoListType::class, $toDoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('to_do_list_edit', ['id' => $toDoList->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('to_do_list/edit.html.twig', [
            'to_do_list' => $toDoList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'to_do_list_delete', methods: ['POST'])]
    public function delete(Request $request, ToDoList $toDoList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$toDoList->getId(), $request->request->get('_token'))) {
            $entityManager->remove($toDoList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('to_do_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
