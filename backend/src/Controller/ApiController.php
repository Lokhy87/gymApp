<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Workout;
use App\Repository\ExercisesMusclesRepository;
use App\Repository\ExercisesRepository;
use App\Repository\ExercisesVariantsRepository;
use App\Repository\MuscleGroupsRepository;
use App\Repository\MusclesRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/workouts', name: 'get_workouts', methods: ['GET'])]
    public function get_workouts(Request $request, WorkoutRepository $workoutRepository): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        $date = $request->query->get('date');
        $exerciseId = $request->query->get('exercise_id');
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        $qb = $workoutRepository->createQueryBuilder('w')
            ->where('w.user = :user')
            ->setParameter('user', $user);

        if ($date) {
            $startDate = new \DateTimeImmutable($date . ' 00:00:00');
            $endDate = new \DateTimeImmutable($date . ' 23:59:59');
            $qb->andWhere('w.date BETWEEN :start AND :end')
                ->setParameter('start', $startDate)
                ->setParameter('end', $endDate);
        }

        if ($exerciseId) {
            $qb->andWhere('w.exercise = :exerciseId')
                ->setParameter('exerciseId', $exerciseId);
        }
        if ($from && $to) {
            $startDate = new \DateTimeImmutable($from . ' 00:00:00');
            $endDate = new \DateTimeImmutable($to . ' 23:59:59');
            $qb->andWhere('w.date BETWEEN :start AND :end')
                ->setParameter('start', $startDate)
                ->setParameter('end', $endDate);
        }

        $qb->orderBy('w.date', 'ASC');
        $workouts = $qb->getQuery()->getResult();

        $data = array_map(fn($w) => [
            'id' => $w->getId(),
            'exercise_id' => $w->getExercise()->getId(),
            'sets' => $w->getSets(),
            'reps' => $w->getReps(),
            'weight' => $w->getWeight(),
            'comments' => $w->getComments(),
            'date' => $w->getDate()->format('Y-m-d H:i:s')
        ], $workouts);

        return $this->json($data);
    }

    #[Route('/workouts/{id}', name: 'get_workout_details', methods: ['GET'])]
    public function get_workout_details(int $id, WorkoutRepository $workoutRepository): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        $workout = $workoutRepository->findOneBy(['id' => $id, 'user' => $user]);
        if (!$workout) return $this->json(['message' => 'Workout not found'], 404);

        return $this->json([
            'id' => $workout->getId(),
            'exercise_id' => $workout->getExercise()->getId(),
            'sets' => $workout->getSets(),
            'reps' => $workout->getReps(),
            'weight' => $workout->getWeight(),
            'comments' => $workout->getComments(),
            'date' => $workout->getDate()->format('Y-m-d H:i:s')
        ]);
    }

    #[Route('/workouts/{id}', name: 'update_workout', methods: ['PUT'])]
    public function update_workout(int $id, Request $request, WorkoutRepository $workoutRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        $workout = $workoutRepository->findOneBy(['id' => $id, 'user' => $user]);
        if (!$workout) return $this->json(['message' => 'Workout not found'], 404);

        $data = json_decode($request->getContent(), true);

        if (isset($data['sets'])) $workout->setSets($data['sets']);
        if (isset($data['reps'])) $workout->setReps($data['reps']);
        if (isset($data['weight'])) $workout->setWeight((float)$data['weight']);
        if (isset($data['comments'])) $workout->setComments($data['comments']);

        $entityManager->flush();

        return $this->json(['message' => 'Workout updated successfully']);
    }

    #[Route('/workouts/{id}', name: 'delete_workout', methods: ['DELETE'])]
    public function delete_workout(int $id, WorkoutRepository $workoutRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        $workout = $workoutRepository->findOneBy(['id' => $id, 'user' => $user]);
        if (!$workout) return $this->json(['message' => 'Workout not found'], 404);

        $entityManager->remove($workout);
        $entityManager->flush();

        return $this->json(['message' => 'Workout deleted successfully']);
    }


    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function register_user(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email']) || empty($data['password']) || empty($data['name'])) {
            return $this->json(['message' => 'Missing required fields'], 400);
        }

        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->json(['message' => 'Email already exists'], 409);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        if (isset($data['location'])) {
            $user->setLocation($data['location']);
        }

        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'User registered successfully'], 201);
    }

    #[Route('/profile', name: 'get_profile', methods: ['GET'])]
    public function get_profile(): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'location' => $user->getLocation()
        ]);
    }

    #[Route('/profile', name: 'update_profile', methods: ['PUT'])]
    public function update_profile(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) $user->setName($data['name']);
        if (isset($data['email'])) $user->setEmail($data['email']);
        if (isset($data['location'])) $user->setLocation($data['location']);

        $entityManager->flush();

        return $this->json(['message' => 'Profile updated successfully']);
    }

    #[Route('/profile', name: 'delete_profile', methods: ['DELETE'])]
    public function delete_profile(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json(['message' => 'Profile deleted successfully']);
    }

    #[Route('/login_check', name: 'login_check', methods: ['POST'])]
    public function login_check(): void
    {
        // Interceptado por LexikJWT
    }

}
