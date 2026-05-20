import { Component, ChangeDetectorRef } from '@angular/core';
import { RouterLink, ActivatedRoute } from '@angular/router';
import {
  FormBuilder,
  ReactiveFormsModule,
  Validators
} from '@angular/forms';
import { HttpErrorResponse } from '@angular/common/http';

import { Card } from '../../shared/components/card/card';
import { ExerciseService } from '../../services/exercises';
import { WorkoutService } from '../../services/workout';

interface Exercise {
  id: number;
  name: string;
  image: string;
  muscle_group_id: number;
}

interface CreateWorkoutRequest {
  sets: number;
  reps: number;
  weight: number;
  comments: string;
  exercise_id: number;
}

@Component({
  selector: 'app-exercises',
  standalone: true,
  imports: [
    RouterLink,
    Card,
    ReactiveFormsModule
  ],
  templateUrl: './exercises.html',
  styleUrl: './exercises.css',
})
export class Exercises {

  groupId!: number;

  exercises: Exercise[] = [];
  loading = true;

  showModal = false;
  selectedExercise: Exercise | null = null;

  submitted = false;

  workoutForm;

  constructor(
    private route: ActivatedRoute,
    private exerciseService: ExerciseService,
    private workoutService: WorkoutService,
    private fb: FormBuilder,
    private cdr: ChangeDetectorRef
  ) {

    this.workoutForm = this.fb.group({
      sets: [3, [Validators.required, Validators.min(1)]],
      reps: [10, [Validators.required, Validators.min(1)]],
      weight: [0, [Validators.required, Validators.min(0)]],
      comments: [''],
      exercise_id: [null as number | null, Validators.required]
    });
  }

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      this.groupId = Number(params['group']);
      this.loadExercises();
    });
  }

  loadExercises(): void {

    this.loading = true;

    this.exerciseService.getExercises().subscribe({
      next: (data: Exercise[]) => {

        this.exercises = data.filter(
          e => Number(e.muscle_group_id) === Number(this.groupId)
        );

        this.loading = false;

        // 🔥 FORZAR REFRESH (Angular 21 edge cases)
        this.cdr.detectChanges();
      },

      error: (err: HttpErrorResponse) => {
        console.error('Error loading exercises:', err);

        this.loading = false;
        this.cdr.detectChanges();
      }
    });
  }

  openExerciseModal(exercise: Exercise): void {

    this.selectedExercise = exercise;
    this.submitted = false;

    this.workoutForm.reset({
      sets: 3,
      reps: 10,
      weight: 0,
      comments: '',
      exercise_id: exercise.id
    });

    this.showModal = true;
  }

  closeModal(): void {

    this.showModal = false;
    this.selectedExercise = null;
    this.submitted = false;

    this.workoutForm.reset({
      sets: 3,
      reps: 10,
      weight: 0,
      comments: '',
      exercise_id: null
    });
  }

  saveWorkout(): void {

    this.submitted = true;

    if (this.workoutForm.invalid) {
      this.workoutForm.markAllAsTouched();
      return;
    }

    const form = this.workoutForm.getRawValue() as CreateWorkoutRequest;

    const payload: CreateWorkoutRequest = {
      sets: form.sets,
      reps: form.reps,
      weight: form.weight,
      comments: form.comments,
      exercise_id: form.exercise_id!
    };

    this.workoutService.createWorkout(payload).subscribe({
      next: (response) => {
        console.log('Workout saved:', response);
        this.closeModal();
      },
      error: (err: HttpErrorResponse) => {
        console.error('Error saving workout:', err);
      }
    });
  }

  trackById(_: number, item: Exercise): number {
    return item.id;
  }
}