import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

import {
  CreateWorkoutRequest,
  CreateWorkoutResponse
} from '../shared/interfaces/workout.interface';

@Injectable({
  providedIn: 'root'
})
export class WorkoutService {

  private apiUrl =
    'http://localhost:8050/api/workouts';

  constructor(
    private http: HttpClient
  ) {}

  createWorkout(
  workout: CreateWorkoutRequest
    ): Observable<CreateWorkoutResponse> {

    return this.http.post<
      CreateWorkoutResponse
    >(this.apiUrl, workout);
  }
}