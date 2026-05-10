<?php

namespace App\Controller;

use App\Entity\TrainingMethod;
use App\Form\TrainingMethodType;
use App\Repository\TrainingMethodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/training/method')]
final class TrainingMethodController extends AbstractController
{
    #[Route(name: 'app_training_method_index', methods: ['GET'])]
    public function index(TrainingMethodRepository $trainingMethodRepository): Response
    {
        return $this->render('training_method/index.html.twig', [
            'training_methods' => $trainingMethodRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_training_method_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainingMethod = new TrainingMethod();
        $form = $this->createForm(TrainingMethodType::class, $trainingMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingMethod);
            $entityManager->flush();

            return $this->redirectToRoute('app_training_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_method/new.html.twig', [
            'training_method' => $trainingMethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_method_show', methods: ['GET'])]
    public function show(TrainingMethod $trainingMethod): Response
    {
        return $this->render('training_method/show.html.twig', [
            'training_method' => $trainingMethod,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_training_method_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingMethod $trainingMethod, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainingMethodType::class, $trainingMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_training_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_method/edit.html.twig', [
            'training_method' => $trainingMethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_training_method_delete', methods: ['POST'])]
    public function delete(Request $request, TrainingMethod $trainingMethod, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingMethod->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trainingMethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_training_method_index', [], Response::HTTP_SEE_OTHER);
    }
}
