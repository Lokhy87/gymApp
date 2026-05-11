<?php

namespace App\Controller;

use App\Repository\ExercisesMusclesRepository;
use App\Repository\ExercisesRepository;
use App\Repository\ExercisesVariantsRepository;
use App\Repository\MuscleGroupsRepository;
use App\Repository\MusclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Workout;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api', name: 'api_')]
final class ApiController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }


    #[Route('/exercises', name: 'api_list_exercises', methods: ['GET'])]
    public function list_exercises(Request $request, ExercisesRepository $em): JsonResponse
    {
        $muscleGroupId = $request->query->get('muscle_group_id');

        if($muscleGroupId){
            $exercises = $em->findBy(['muscleGroup' => $muscleGroupId]);
        } else {
            $exercises = $em->findAll();
        }

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

    #[Route('/exercises_muscles', name: 'api_list_muscles', methods: ['GET'])]
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

    #[Route('/exercises_variants', name: 'api_list_exercises_variants', methods: ['GET'])]
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

    #[Route('/muscle_groups', name: 'api_list_muscle_groups', methods: ['GET'])]
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

    #[Route('/muscle', name: 'api_list_muscle', methods: ['GET'])]
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

    #[Route('/workouts', name: 'create_workout', methods: ['POST'])]
    public function create_workout(Request $request, ExercisesRepository $exercisesRepository, EntityManagerInterface $entityManager): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $exerciseId = $data['exercise_id'] ?? null;
        $exercise = $exercisesRepository->find($exerciseId);

        if (!$exercise) {
            return $this->json(['message' => 'Exercise not found'], 404);
        }

        $workout = new Workout();

        $user = $this->getUser();

        if (!$user) {

            $user = $entityManager->getRepository(\App\Entity\User::class)->find(1);

            // Cuando el login esté listo, descomentar estas lineas:
            // return $this->json(['message' => 'Unauthorized. Please login.'], 401);
        }
        // ---------------------------------------

        $workout->setUser($user);
        $workout->setExercise($exercise);
        $workout->setSets($data['sets'] ?? 0);
        $workout->setReps($data['reps'] ?? 0);
        $workout->setWeight($data['weight'] ?? 0.0);
        $workout->setComments($data['comments'] ?? null);

        $workout->setDate(new \DateTimeImmutable());

        // 4. Guardamos en la base de datos
        $entityManager->persist($workout);
        $entityManager->flush();

        return $this->json([
            'message' => 'Workout created successfully',
            'workout_id' => $workout->getId()
        ], 201);
    }
}
