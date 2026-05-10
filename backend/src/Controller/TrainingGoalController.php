<?php

namespace App\Controller;

use App\Entity\TrainingGoal;
use App\Form\TrainingGoalType;
use App\Repository\TrainingGoalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/training/goal')]
final class TrainingGoalController extends AbstractController
{
    #[Route(name: 'app_training_goal_index', methods: ['GET'])]
    public function index(TrainingGoalRepository $trainingGoalRepository): Response
    {
        return $this->render('training_goal/index.html.twig', [
            'training_goals' => $trainingGoalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_training_goal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainingGoal = new TrainingGoal();
        $form = $this->createForm(TrainingGoalType::class, $trainingGoal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingGoal);
            $entityManager->flush();

            return $this->redirectToRoute('app_training_goal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_goal/new.html.twig', [
            'training_goal' => $trainingGoal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_goal_show', methods: ['GET'])]
    public function show(TrainingGoal $trainingGoal): Response
    {
        return $this->render('training_goal/show.html.twig', [
            'training_goal' => $trainingGoal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_training_goal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingGoal $trainingGoal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainingGoalType::class, $trainingGoal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_training_goal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_goal/edit.html.twig', [
            'training_goal' => $trainingGoal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_goal_delete', methods: ['POST'])]
    public function delete(Request $request, TrainingGoal $trainingGoal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingGoal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trainingGoal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_training_goal_index', [], Response::HTTP_SEE_OTHER);
    }
}
