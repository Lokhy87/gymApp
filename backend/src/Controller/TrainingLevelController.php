<?php

namespace App\Controller;

use App\Entity\TrainingLevel;
use App\Form\TrainingLevelType;
use App\Repository\TrainingLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/training/level')]
#[IsGranted('ROLE_ADMIN')]
final class TrainingLevelController extends AbstractController
{
    #[Route(name: 'app_training_level_index', methods: ['GET'])]
    public function index(TrainingLevelRepository $trainingLevelRepository): Response
    {
        return $this->render('training_level/index.html.twig', [
            'training_levels' => $trainingLevelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_training_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainingLevel = new TrainingLevel();
        $form = $this->createForm(TrainingLevelType::class, $trainingLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingLevel);
            $entityManager->flush();

            return $this->redirectToRoute('app_training_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_level/new.html.twig', [
            'training_level' => $trainingLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_level_show', methods: ['GET'])]
    public function show(TrainingLevel $trainingLevel): Response
    {
        return $this->render('training_level/show.html.twig', [
            'training_level' => $trainingLevel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_training_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingLevel $trainingLevel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainingLevelType::class, $trainingLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_training_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_level/edit.html.twig', [
            'training_level' => $trainingLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_level_delete', methods: ['POST'])]
    public function delete(Request $request, TrainingLevel $trainingLevel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingLevel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trainingLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_training_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
