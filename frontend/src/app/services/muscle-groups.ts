import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { MuscleGroupInterface } from '../shared/interfaces/muscle-groups.interface';

@Injectable({
  providedIn: 'root',
})
export class MuscleGroupService {
  private url = 'http://localhost:8050/api_muscle_groups';

  constructor(private http: HttpClient) {}

  getMuscleGroups(): Observable<MuscleGroupInterface[]> {
    return this.http.get<MuscleGroupInterface[]>(this.url);
  }
}
