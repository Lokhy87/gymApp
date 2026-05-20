import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http'; // 👈 Quitamos HttpHeaders, ya no se usan aquí
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { UserProfile } from '../shared/interfaces/user.interface'; // 👈 Ajusta la ruta a tu archivo
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private baseUrl = environment.apiUrl;

  private userNameSubject = new BehaviorSubject<string>('');
  userName$ = this.userNameSubject.asObservable();

  constructor(private http: HttpClient) {
    const cached = localStorage.getItem('userName');
    if (cached) {
      this.userNameSubject.next(cached);
    }
  }

  // LOGIN
  login(credentials: { username: string; password: string }): Observable<any> {
    return this.http.post<any>(`${this.baseUrl}/login_check`, credentials).pipe(
      tap(response => {
        if (response.token) {
          localStorage.setItem('token', response.token);
          localStorage.removeItem('userName');
          this.loadUserProfile();
        }
      })
    );
  }

  // REGISTER
  register(userData: any): Observable<any> {
    return this.http.post<any>(`${this.baseUrl}/register`, userData);
  }

  // GET /api/me 
  // 👈 Tipamos con UserProfile y dejamos que el interceptor maneje los tokens de forma limpia
  getProfile(): Observable<UserProfile> {
    return this.http.get<UserProfile>(`${this.baseUrl}/me`);
  }

  // Actualizar el perfil
  updateProfile(
    data: UserProfile
  ): Observable<any> {

    return this.http.put(
      `${this.baseUrl}/me`,
      data
    );
  }

  // Cargar perfil optimizado
  loadUserProfile(): void {
    const cached = localStorage.getItem('userName');
    if (cached) {
      this.userNameSubject.next(cached);
      return;
    }

    this.getProfile().subscribe({
      next: (profile) => {
        const nameToStore = profile.name || profile.username;
        localStorage.setItem('userName', nameToStore);
        this.userNameSubject.next(nameToStore);
      },
      error: (err) => console.error('Error in loadUserProfile:', err)
    });
  }

  getUserName(): string | null {
    return localStorage.getItem('userName');
  }

  // LOGOUT
  logout(): void {
    localStorage.removeItem('token');
    localStorage.removeItem('userName');
    this.userNameSubject.next('');
  }
}