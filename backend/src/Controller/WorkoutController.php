<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Repository\ExercisesRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/workouts')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class WorkoutController extends AbstractController
{
    #[Route('', name: 'api_workouts_list', methods: ['GET'])]
    public function index(Request $request, WorkoutRepository $workoutRepository): JsonResponse
    {
        $currentUser = $this->getUser();

        $dateParam = $request->query->get('date');
        $exerciseId = $request->query->get('exercise_id');
        $fromParam = $request->query->get('from');
        $toParam = $request->query->get('to');

        if ($exerciseId && $fromParam && $toParam) {
            $workouts = $workoutRepository->findProgress(
                $currentUser,
                $exerciseId,
                new \DateTimeImmutable($fromParam),
                new \DateTimeImmutable($toParam)
            );
        }
        elseif ($dateParam) {
            $workouts = $workoutRepository->findByDate($currentUser, new \DateTimeImmutable($dateParam));
        }

        else {
            $workouts = $workoutRepository->findBy(['user' => $currentUser], ['date' => 'DESC']);
        }

        $responseData = [];
        foreach ($workouts as $workout) {
            $responseData[] = [
                'id' => $workout->getId(),
                'sets' => $workout->getSets(),
                'reps' => $workout->getReps(),
                'weight' => $workout->getWeight(),
                'comments' => $workout->getComments(),
                'date' => $workout->getDate()->format('Y-m-d'),
                'exercise' => [
                    'id' => $workout->getExercise()->getId(),
                    'name' => $workout->getExercise()->getName(),
                ]
            ];
        }

        return $this->json($responseData);
    }

    #[Route('/{id}', name: 'api_workouts_show', methods: ['GET'])]
    public function show(Workout $workout): JsonResponse
    {
        if ($workout->getUser() !== $this->getUser()) {
            return $this->json(['error' => 'Access Denied'], 403);
        }

        return $this->json([
            'id' => $workout->getId(),
            'sets' => $workout->getSets(),
            'reps' => $workout->getReps(),
            'weight' => $workout->getWeight(),
            'comments' => $workout->getComments(),
            'date' => $workout->getDate()->format('Y-m-d'),
            'exercise_id' => $workout->getExercise()->getId()
        ]);
    }

    #[Route('', name: 'api_workouts_create', methods: ['POST'])]
    public function create(
        Request $request,
        ExercisesRepository $exercisesRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = $request->toArray(); // Extraemos el JSON enviado por Angular

        $exercise = $exercisesRepository->find($data['exercise_id'] ?? null);
        if (!$exercise) {
            return $this->json(['error' => 'Exercise not found'], 404);
        }

        $workout = new Workout();
        $workout->setUser($this->getUser());
        $workout->setExercise($exercise);
        $workout->setSets((int)$data['sets']);
        $workout->setReps((int)$data['reps']);
        $workout->setWeight((float)$data['weight']);
        $workout->setComments($data['comments'] ?? null);
        $workout->setDate(new \DateTimeImmutable($data['date'] ?? 'now'));

        $entityManager->persist($workout);
        $entityManager->flush();

        return $this->json(['message' => 'Workout created successfully', 'id' => $workout->getId()], 210);
    }

    #[Route('/{id}', name: 'api_workouts_update', methods: ['PUT'])]
    public function update(
        Workout $workout,
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        if ($workout->getUser() !== $this->getUser()) {
            return $this->json(['error' => 'Access Denied'], 403);
        }

        $data = $request->toArray();
        $workout->setSets((int)$data['sets']);
        $workout->setReps((int)$data['reps']);
        $workout->setWeight((float)$data['weight']);
        $workout->setComments($data['comments'] ?? null);

        $entityManager->flush();

        return $this->json(['message' => 'Workout updated successfully']);
    }

    #[Route('/{id}', name: 'api_workouts_delete', methods: ['DELETE'])]
    public function delete(Workout $workout, EntityManagerInterface $entityManager): JsonResponse
    {
        if ($workout->getUser() !== $this->getUser()) {
            return $this->json(['error' => 'Access Denied'], 403);
        }

        $entityManager->remove($workout);
        $entityManager->flush();

        return $this->json(['message' => 'Workout deleted successfully']);
    }
}
