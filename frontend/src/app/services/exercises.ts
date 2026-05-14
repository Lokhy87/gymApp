import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ExercisesInterface } from '../shared/interfaces/exercises.interface';

@Injectable({
  providedIn: 'root',
})
export class ExerciseService {
   private url = 'http://localhost:8050/api/exercises'

   constructor(private http: HttpClient) {}

   getExercises() {
    return this.http.get<any[]>(this.url);
   }
}
