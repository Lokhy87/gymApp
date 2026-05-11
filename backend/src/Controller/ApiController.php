<?php

namespace App\Controller;

use App\Repository\ExercisesMusclesRepository;
use App\Repository\ExercisesRepository;
use App\Repository\ExercisesVariantsRepository;
use App\Repository\MuscleGroupsRepository;
use App\Repository\MusclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }


    #[Route('/api_exercises', name: 'api_list_exercises', methods: ['GET'])]
    public function list_exercises( ExercisesRepository $em): JsonResponse
    {
        $exercises = $em->findAll();
        if (!$exercises) {
        return $this->json(['message' => 'Product not found'], 404);
        }
        $data = [];

        foreach ($exercises as $exercise) {
            $data [ ] = [
                'id' => $exercise->getId(),
                'name' => $exercise->getName(),
                'image' => $exercise->getImage(),
                'muscle_group_id' => $exercise->getMuscleGroup()->getId(),
            ];
        }

        return new jsonResponse($data);
    }

    #[Route('/api_exercises_muscles', name: 'api_list_muscles', methods: ['GET'])]
    public function list_exercises_muscles( ExercisesMusclesRepository $em): JsonResponse
    {
        $exercises_muscles = $em->findAll();
        if (!$exercises_muscles) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $data = [];

        foreach ($exercises_muscles as $exercise) {
            $data [ ] = [
                'id' => $exercise->getId(),
                'rol' => $exercise->getRole(),
                'muscle_id' => $exercise->getMuscle()->getId(),
            ];
        }

        return new jsonResponse($data);
    }

    #[Route('/api_exercises_variants', name: 'api_list_exercises_variants', methods: ['GET'])]
    public function list_exercises_variants( ExercisesVariantsRepository $em): JsonResponse
    {
        $exercises_variants = $em->findAll();
        if (!$exercises_variants) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $data = [];

        foreach ($exercises_variants as $exercise) {
            $data [ ] = [
                'id' => $exercise->getId(),
                'name' => $exercise->getName(),
                'exercise_id' => $exercise->getExercise()->getId(),
            ];
        }

        return new jsonResponse($data);
    }

    #[Route('/api_muscle_groups', name: 'api_list_muscle_groups', methods: ['GET'])]
    public function list_muscle_groups( MuscleGroupsRepository $em): JsonResponse
    {
        $muscle_groups = $em->findAll();
        if (!$muscle_groups) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $data = [];

        foreach ($muscle_groups as $exercise) {
            $data [ ] = [
                'id' => $exercise->getId(),
                'name' => $exercise->getName(),
                'image' => $exercise->getImage(),
            ];
        }

        return new jsonResponse($data);
    }

    #[Route('/api_muscle', name: 'api_list_muscle', methods: ['GET'])]
    public function list_muscle( MusclesRepository $em): JsonResponse
    {
        $muscle = $em->findAll();
        if (!$muscle) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $data = [];

        foreach ($muscle as $exercise) {
            $data [ ] = [
                'id' => $exercise->getId(),
                'name' => $exercise->getName(),
                'muscle_group_id' => $exercise->getMuscleGroup()->getId(),
            ];
        }

        return new jsonResponse($data);
    }

}
