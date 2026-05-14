<?php

namespace App\Controller;

use App\Entity\ExercisesMuscles;
use App\Form\ExercisesMusclesType;
use App\Repository\ExercisesMusclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/exercises-muscles')]
#[IsGranted('ROLE_ADMIN')]
final class ExercisesMusclesController extends AbstractController
{
    #[Route('', name: 'app_exercises_muscles_index', methods: ['GET'])]
    public function index(ExercisesMusclesRepository $exercisesMusclesRepository): Response
    {
        return $this->render('exercises_muscles/index.html.twig', [
            'exercises_muscles' => $exercisesMusclesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exercises_muscles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercisesMuscle = new ExercisesMuscles();
        $form = $this->createForm(ExercisesMusclesType::class, $exercisesMuscle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercisesMuscle);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercises_muscles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercises_muscles/new.html.twig', [
            'exercises_muscle' => $exercisesMuscle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercises_muscles_show', methods: ['GET'])]
    public function show(ExercisesMuscles $exercisesMuscle): Response
    {
        return $this->render('exercises_muscles/show.html.twig', [
            'exercises_muscle' => $exercisesMuscle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercises_muscles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExercisesMuscles $exercisesMuscle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExercisesMusclesType::class, $exercisesMuscle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercises_muscles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercises_muscles/edit.html.twig', [
            'exercises_muscle' => $exercisesMuscle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercises_muscles_delete', methods: ['POST'])]
    public function delete(Request $request, ExercisesMuscles $exercisesMuscle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercisesMuscle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercisesMuscle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercises_muscles_index', [], Response::HTTP_SEE_OTHER);
    }
}
