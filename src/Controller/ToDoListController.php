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
     * @Route("/{id}/{name}/download", name="to_do_list_download", methods={"GET", "POST"})
     */
    public function isDownload(string $name, ToDoList $toDoList): Response
    {
        if (isset($_POST['form'])) {
            $filesName = $_POST['form'];

            $this->download($filesName, $name, $toDoList);
            return $this->renderForm('to_do_list/fileSuccess.html.twig', [
                'to_do_list' => $toDoList,
                'filesName' => $filesName,
                'type' => $name
            ]);

        } else {
            if (is_dir('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Document/' . $name)) {
                $finder = new Finder();
                $files = $finder->files()->in('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Document/' . $name);
                $filesName = [];
                foreach ($files as $file) {
                    array_push($filesName, $file->getRelativePathname());
                }

                if (count($files) === 1 && $name === "devis") {
                    $this->download($filesName, $name, $toDoList);
                    return $this->redirectToRoute('session_index', [], Response::HTTP_SEE_OTHER);
                }
            }

            return $this->renderForm('to_do_list/file.html.twig', [
                'to_do_list' => $toDoList,
                'filesName' => $filesName,
                'type' => $name
            ]);
        }
    }

    /**
     * @param array $filesName
     * @param string $name
     * @param ToDoList $toDoList
     */
    public function download(array $filesName, string $name, ToDoList $toDoList)
    {
        $fsObject = new Filesystem();
        foreach ($filesName as $file) {
            $fsObject->copy('D:/Professional/LMT/symfony_lmt/lmt-formation/src/Document/' . $name . '/' . $file, 'D:/Professional/LMT/symfony_lmt/lmt-formation/src/session/' . $toDoList->getSession()->getCustomer()[0]->getName() . '/' . $toDoList->getSession()->getSessionDate()[0]->getDateFormation() . '_' . $toDoList->getSession()->getStandardTraining()->getReference() . '_' . $toDoList->getSession()->getId() . '_' . $toDoList->getSession()->getStatus() . '/' . $file);
        }
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
        if ($this->isCsrfTokenValid('delete' . $toDoList->getId(), $request->request->get('_token'))) {
            $entityManager->remove($toDoList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('to_do_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
