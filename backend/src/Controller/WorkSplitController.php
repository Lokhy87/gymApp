<?php

namespace App\Controller;

use App\Entity\WorkSplit;
use App\Form\WorkSplitType;
use App\Repository\WorkSplitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/work/split')]
final class WorkSplitController extends AbstractController
{
    #[Route(name: 'app_work_split_index', methods: ['GET'])]
    public function index(WorkSplitRepository $workSplitRepository): Response
    {
        return $this->render('work_split/index.html.twig', [
            'work_splits' => $workSplitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_work_split_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workSplit = new WorkSplit();
        $form = $this->createForm(WorkSplitType::class, $workSplit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workSplit);
            $entityManager->flush();

            return $this->redirectToRoute('app_work_split_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work_split/new.html.twig', [
            'work_split' => $workSplit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_work_split_show', methods: ['GET'])]
    public function show(WorkSplit $workSplit): Response
    {
        return $this->render('work_split/show.html.twig', [
            'work_split' => $workSplit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_work_split_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkSplit $workSplit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkSplitType::class, $workSplit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_work_split_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work_split/edit.html.twig', [
            'work_split' => $workSplit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_work_split_delete', methods: ['POST'])]
    public function delete(Request $request, WorkSplit $workSplit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workSplit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($workSplit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_work_split_index', [], Response::HTTP_SEE_OTHER);
    }
}
