<?php

namespace App\Controller;

use App\Entity\User;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\SecurityBundle\Security;
use DateTime;

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
            'project' => 'GymFlow API',
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

        if (!$user instanceof User) {
            return $this->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json([
                'message' => 'Invalid JSON'
            ], 400);
        }

        // Validación básica
        if (
            !isset($data['exercise_id']) ||
            !isset($data['sets']) ||
            !isset($data['reps'])
        ) {
            return $this->json([
                'message' => 'Missing required fields'
            ], 400);
        }

        $exercise = $exercisesRepository
            ->find($data['exercise_id']);

        if (!$exercise) {
            return $this->json([
                'message' => 'Exercise not found'
            ], 404);
        }

        $workout = new Workout();

        $workout->setUser($user);
        $workout->setExercise($exercise);

        $workout->setSets((int) $data['sets']);
        $workout->setReps((int) $data['reps']);
        $workout->setWeight(
            (float) ($data['weight'] ?? 0)
        );

        $workout->setComments(
            $data['comments'] ?? null
        );

        // Siempre fecha_servidor
        $workout->setDate(
            new \DateTime()
        );

        $entityManager->persist($workout);
        $entityManager->flush();

        return $this->json([
            'message' => 'Workout created successfully',
            'workout_id' => $workout->getId()
        ], 201);
    }

    #[Route('/workouts/{id}', name: 'delete_workout', methods: ['DELETE'])]
    public function delete_workout(
        int $id,
        WorkoutRepository $workoutRepository,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {

        $user = $security->getUser();

        if (!$user instanceof User) {
            return $this->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $workout =
            $workoutRepository->find($id);

        if (!$workout) {
            return $this->json([
                'message' => 'Workout not found'
            ], 404);
        }

        // Seguridad:
        // impedir borrar workouts de otros usuarios
        if (
            $workout->getUser()?->getId()
            !== $user->getId()
        ) {
            return $this->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $entityManager->remove(
            $workout
        );

        $entityManager->flush();

        return $this->json([
            'message' =>
                'Workout deleted'
        ]);
    }

    #[Route('/workouts/{id}', name: 'update_workout', methods: ['PUT'])]
    public function update_workout(
        int $id,
        Request $request,
        WorkoutRepository $workoutRepository,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {

        $user = $security->getUser();

        if (!$user instanceof User) {
            return $this->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $workout =
            $workoutRepository
                ->find($id);

        if (!$workout) {
            return $this->json([
                'message' =>
                    'Workout not found'
            ], 404);
        }

        if (
            $workout->getUser()?->getId()
            !== $user->getId()
        ) {
            return $this->json([
                'message' =>
                    'Forbidden'
            ], 403);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );

        $workout->setSets(
            (int) ($data['sets']
                ?? $workout->getSets())
        );

        $workout->setReps(
            (int) ($data['reps']
                ?? $workout->getReps())
        );

        $workout->setWeight(
            (float) ($data['weight']
                ?? $workout->getWeight())
        );

        $workout->setComments(
            $data['comments']
            ?? $workout->getComments()
        );

        $entityManager->flush();

        return $this->json([
            'message' =>
                'Workout updated'
        ]);
    }

    #[Route('/login_check', name: 'login_check', methods: ['POST'])]
    public function login_check(): void
    {
        // Interceptado JWT
    }

    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $username = $data['username'] ?? null;
        $plainPassword = $data['password'] ?? null;
        $location = $data['location'] ?? 'Valencia'; // Si no viene en el JSON, asignamos 'Valencia' por defecto

        // Validación estricta de los campos requeridos por tu SQL
        if (!$email || !$username || !$plainPassword) {
            return $this->json(['message' => 'Missing required fields'], 400);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setRoles(['ROLE_USER']); // Esto se guardará como JSON ["ROLE_USER"] cumpliendo el check(json_valid)

        // Cumplimos con los campos específicos de tu esquema
        $user->setName($username);
        $user->setLocation($location);

        // Encriptación de contraseña
        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'User registered successfully',
            'user' => $user->getUserIdentifier()
        ], 201);
    }

    #[Route('/me', name: 'current_user', methods: ['GET'])]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['message' => 'User not found'], 401);
        }

        // Retornamos exactamente la estructura que espera mapear tu profile.ts de Angular
        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'location' => $user->getLocation(),
            'name' => $user->getName(),
        ]);
    }

    #[Route('/me', name: 'update_me', methods: ['PUT'])]
    public function update_me(
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {

        $user = $security->getUser();

        if (!$user instanceof User) {
            return $this->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );

        $user->setName(
            $data['name']
            ?? $user->getName()
        );

        $user->setUsername(
            $data['username']
            ?? $user->getUsername()
        );

        $user->setEmail(
            $data['email']
            ?? $user->getEmail()
        );

        $user->setLocation(
            $data['location']
            ?? $user->getLocation()
        );

        $entityManager->flush();

        return $this->json([
            'message' => 'Profile updated',
            'user' => [
                'name' => $user->getName(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'location' => $user->getLocation()
            ]
        ]);
    }

    #[Route('/history', name: 'history', methods: ['GET'])]
    public function history(
        WorkoutRepository $workoutRepository,
        Security $security
    ): JsonResponse {

        $user = $security->getUser();

        if (!$user instanceof User) {
            return $this->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $workouts = $workoutRepository->findBy([
            'user' => $user
        ]);

        $data = [];

        foreach ($workouts as $workout) {

            $data[] = [
                'id' => $workout->getId(),
                'sets' => $workout->getSets(),
                'reps' => $workout->getReps(),
                'weight' => $workout->getWeight(),
                'comments' => $workout->getComments(),
                'date' => $workout
                    ->getDate()
                    ->format('Y-m-d H:i:s'),

                'exercise_name' => $workout
                    ->getExercise()
                    ->getName()
            ];
        }

        return $this->json($data);
    }

    #[Route('/progress', name: 'progress', methods: ['GET'])]
    public function progress(
        Request $request,
        WorkoutRepository $workoutRepository,
        Security $security
    ): JsonResponse {

        $user = $security->getUser();

        if (!$user instanceof User) {
            return $this->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $exercise =
            $request->query->get(
                'exercise'
            );

        $months =
            (int) $request
                ->query
                ->get(
                    'months',
                    6
                );

        if (!$exercise) {
            return $this->json([
                'message' =>
                    'Exercise required'
            ], 400);
        }

        // fecha límite
        $fromDate =
            new \DateTime();

        $fromDate->modify(
            "-{$months} months"
        );

        // QueryBuilder optimizado
        $workouts =
            $workoutRepository
                ->createQueryBuilder(
                    'w'
                )
                ->join(
                    'w.exercise',
                    'e'
                )
                ->where(
                    'w.user = :user'
                )
                ->andWhere(
                    'e.name = :exercise'
                )
                ->andWhere(
                    'w.date >= :fromDate'
                )
                ->setParameter(
                    'user',
                    $user
                )
                ->setParameter(
                    'exercise',
                    $exercise
                )
                ->setParameter(
                    'fromDate',
                    $fromDate
                )
                ->orderBy(
                    'w.date',
                    'ASC'
                )
                ->getQuery()
                ->getResult();

        $data = [];

        foreach (
            $workouts
            as $workout
        ) {

            $data[] = [

                'date' =>
                    $workout
                        ->getDate()
                        ->format(
                            'Y-m-d'
                        ),

                'weight' =>
                    $workout
                        ->getWeight(),

                'sets' =>
                    $workout
                        ->getSets(),

                'reps' =>
                    $workout
                        ->getReps()
            ];
        }

        return $this->json(
            $data
        );
    }

}
