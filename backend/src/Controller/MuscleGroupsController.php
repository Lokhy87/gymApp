<?php

namespace App\Controller;

use App\Entity\MuscleGroups;
use App\Form\MuscleGroupsType;
use App\Repository\MuscleGroupsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/muscle/groups')]
#[IsGranted('ROLE_ADMIN')]
final class MuscleGroupsController extends AbstractController
{
    #[Route(name: 'app_muscle_groups_index', methods: ['GET'])]
    public function index(MuscleGroupsRepository $muscleGroupsRepository): Response
    {
        return $this->render('muscle_groups/index.html.twig', [
            'muscle_groups' => $muscleGroupsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_muscle_groups_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $muscleGroup = new MuscleGroups();
        $form = $this->createForm(MuscleGroupsType::class, $muscleGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($muscleGroup);
            $entityManager->flush();

            return $this->redirectToRoute('app_muscle_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('muscle_groups/new.html.twig', [
            'muscle_group' => $muscleGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_muscle_groups_show', methods: ['GET'])]
    public function show(MuscleGroups $muscleGroup): Response
    {
        return $this->render('muscle_groups/show.html.twig', [
            'muscle_group' => $muscleGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_muscle_groups_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MuscleGroups $muscleGroup, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MuscleGroupsType::class, $muscleGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_muscle_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('muscle_groups/edit.html.twig', [
            'muscle_group' => $muscleGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_muscle_groups_delete', methods: ['POST'])]
    public function delete(Request $request, MuscleGroups $muscleGroup, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$muscleGroup->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($muscleGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_muscle_groups_index', [], Response::HTTP_SEE_OTHER);
    }
}
