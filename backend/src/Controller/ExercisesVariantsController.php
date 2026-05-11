<?php

namespace App\Controller;

use App\Entity\ExercisesVariants;
use App\Form\ExercisesVariantsType;
use App\Repository\ExercisesVariantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/exercises-variants')]
#[IsGranted('ROLE_ADMIN')]
final class ExercisesVariantsController extends AbstractController
{
    #[Route('', name: 'app_exercises_variants_index', methods: ['GET'])]
    public function index(ExercisesVariantsRepository $exercisesVariantsRepository): Response
    {
        return $this->render('exercises_variants/index.html.twig', [
            'exercises_variants' => $exercisesVariantsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exercises_variants_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercisesVariant = new ExercisesVariants();
        $form = $this->createForm(ExercisesVariantsType::class, $exercisesVariant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercisesVariant);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercises_variants_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercises_variants/new.html.twig', [
            'exercises_variant' => $exercisesVariant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercises_variants_show', methods: ['GET'])]
    public function show(ExercisesVariants $exercisesVariant): Response
    {
        return $this->render('exercises_variants/show.html.twig', [
            'exercises_variant' => $exercisesVariant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercises_variants_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExercisesVariants $exercisesVariant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExercisesVariantsType::class, $exercisesVariant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercises_variants_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercises_variants/edit.html.twig', [
            'exercises_variant' => $exercisesVariant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercises_variants_delete', methods: ['POST'])]
    public function delete(Request $request, ExercisesVariants $exercisesVariant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercisesVariant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercisesVariant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercises_variants_index', [], Response::HTTP_SEE_OTHER);
    }
}
