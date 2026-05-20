import { Injectable } from '@angular/core';

import {
  HttpClient
} from '@angular/common/http';

import {
  Observable
} from 'rxjs';

export interface WorkoutHistory {
  id: number;
  sets: number;
  reps: number;
  weight: number;
  comments: string;
  date: string;
  exercise_name: string;
}

export interface UpdateWorkoutRequest {
  sets: number;
  reps: number;
  weight: number;
  comments: string;
}

@Injectable({
  providedIn: 'root'
})

export class HistoryService {

  private apiUrl =
    'http://localhost:8050/api';

  constructor(
    private http:
      HttpClient
  ) { }

  getHistory():
    Observable<
      WorkoutHistory[]
    > {

    return this.http.get<
      WorkoutHistory[]
    >(
      `${this.apiUrl}/history`
    );
  }

  deleteWorkout(
    id: number
  ): Observable<any> {

    return this.http.delete(
      `${this.apiUrl}/workouts/${id}`
    );
  }

  updateWorkout(
    id: number,
    data: UpdateWorkoutRequest
  ): Observable<any> {

    return this.http.put(
      `${this.apiUrl}/workouts/${id}`,
      data
    );
  }
}