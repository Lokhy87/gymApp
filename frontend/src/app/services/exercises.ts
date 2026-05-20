import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { ExercisesInterface } from '../shared/interfaces/exercises.interface';

@Injectable({
  providedIn: 'root',
})
export class ExerciseService {

  private url = `${environment.apiUrl}/exercises`;

  constructor(private http: HttpClient) {}

  getExercises(): Observable<ExercisesInterface[]> {
    return this.http.get<ExercisesInterface[]>(this.url);
  }
}