<?php

namespace App\Controller;

use App\Entity\Exercises;
use App\Form\ExercisesType;
use App\Repository\ExercisesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/exercises')]
#[isGranted('ROLE_ADMIN')]
final class ExercisesController extends AbstractController
{
    #[Route(name: 'app_exercises_index', methods: ['GET'])]
    public function index(ExercisesRepository $exercisesRepository): Response
    {
        return $this->render('exercises/index.html.twig', [
            'exercises' => $exercisesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exercises_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercise = new Exercises();
        $form = $this->createForm(ExercisesType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercises_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercises/new.html.twig', [
            'exercise' => $exercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercises_show', methods: ['GET'])]
    public function show(Exercises $exercise): Response
    {
        return $this->render('exercises/show.html.twig', [
            'exercise' => $exercise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercises_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercises $exercise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExercisesType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercises_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercises/edit.html.twig', [
            'exercise' => $exercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercises_delete', methods: ['POST'])]
    public function delete(Request $request, Exercises $exercise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercise->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercises_index', [], Response::HTTP_SEE_OTHER);
    }
}
