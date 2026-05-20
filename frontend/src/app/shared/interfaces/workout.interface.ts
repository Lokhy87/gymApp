export interface Workout {
  id: number;
  sets: number;
  reps: number;
  weight: number;
  comments: string;
  date: Date;
  exerciseId: number;
  userId: number;
}

export interface CreateWorkoutRequest {
  sets: number;
  reps: number;
  weight: number;
  comments: string;
  exercise_id: number;
}

export interface CreateWorkoutResponse {
  message: string;
  workout_id: number;
}