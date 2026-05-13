<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Repository\ExercisesMusclesRepository;
use App\Repository\ExercisesRepository;
use App\Repository\ExercisesVariantsRepository;
use App\Repository\MuscleGroupsRepository;
use App\Repository\MusclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
final class ApiController extends AbstractController
{
    /**
     * Endpoint de bienvenida o estado de la API
     */
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'project' => 'Notimap / GymFlow API',
            'version' => '1.0',
            'status' => 'online'
        ]);
    }

    #[Route('/exercises', name: 'list_exercises', methods: ['GET'])]
    public function list_exercises(Request $request, ExercisesRepository $repository): JsonResponse
    {
        $muscleGroupId = $request->query->get('muscle_group_id');

        $exercises = $muscleGroupId
            ? $repository->findBy(['muscleGroup' => $muscleGroupId])
            : $repository->findAll();

        if (!$exercises) {
            return $this->json(['message' => 'No exercises found'], 404);
        }

        $data = array_map(fn($e) => [
            'id' => $e->getId(),
            'name' => $e->getName(),
            'image' => $e->getImage(),
            'muscle_group_id' => $e->getMuscleGroup() ? $e->getMuscleGroup()->getId() : null,
        ], $exercises);

        return $this->json($data);
    }

    #[Route('/exercises_muscles', name: 'list_muscles', methods: ['GET'])]
    public function list_exercises_muscles(ExercisesMusclesRepository $repository): JsonResponse
    {
        $data = array_map(fn($em) => [
            'id' => $em->getId(),
            'role' => $em->getRole(),
            'muscle_id' => $em->getMuscle()->getId(),
            'exercise_id' => $em->getExercise()->getId(),
        ], $repository->findAll());

        return $this->json($data ?: ['message' => 'Data not found'], $data ? 200 : 404);
    }

    #[Route('/muscle_groups', name: 'list_muscle_groups', methods: ['GET'])]
    public function list_muscle_groups(MuscleGroupsRepository $repository): JsonResponse
    {
        $data = array_map(fn($mg) => [
            'id' => $mg->getId(),
            'name' => $mg->getName(),
            'image' => $mg->getImage(),
        ], $repository->findAll());

        return $this->json($data);
    }

    #[Route('/workouts', name: 'create_workout', methods: ['POST'])]
    public function create_workout(
        Request $request,
        ExercisesRepository $exercisesRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $user = $this->getUser();

        // Seguridad: Solo usuarios autenticados vía JWT
        if (!$user) {
            return $this->json(['message' => 'Unauthorized. Please login.'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $exerciseId = $data['exercise_id'] ?? null;
        $exercise = $exercisesRepository->find($exerciseId);

        if (!$exercise) {
            return $this->json(['message' => 'Exercise not found'], 404);
        }

        $workout = new Workout();
        $workout->setUser($user);
        $workout->setExercise($exercise);
        $workout->setSets($data['sets'] ?? 0);
        $workout->setReps($data['reps'] ?? 0);
        $workout->setWeight((float)($data['weight'] ?? 0.0));
        $workout->setComments($data['comments'] ?? null);
        $workout->setDate(new \DateTimeImmutable());

        $entityManager->persist($workout);
        $entityManager->flush();

        return $this->json([
            'message' => 'Workout created successfully',
            'workout_id' => $workout->getId()
        ], 201);
    }

    #[Route('/login_check', name: 'login_check', methods: ['POST'])]
    public function login_check(): void
    {
        // Interceptado por LexikJWT
    }
}
