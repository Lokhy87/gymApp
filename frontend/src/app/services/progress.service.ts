import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';

import {
  HttpClient
} from '@angular/common/http';

import {
  Observable
} from 'rxjs';

export interface ProgressData {
  date: string;
  weight: number;
}

@Injectable({
  providedIn: 'root'
})
export class ProgressService {

  private apiUrl = environment.apiUrl;

  constructor(
    private http:
      HttpClient
  ) {}

  getProgress(
    exercise: string,
    months: string
  ): Observable<ProgressData[]> {

    return this.http.get<
      ProgressData[]
    >(
      `${this.apiUrl}/progress`,
      {
        params: {
          exercise,
          months
        }
      }
    );
  }
}