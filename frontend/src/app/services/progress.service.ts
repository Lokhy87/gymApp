import { Injectable } from '@angular/core';

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

  private apiUrl =
    'http://localhost:8050/api';

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