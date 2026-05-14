import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  // Esta es la URL de tu backend de Symfony
  private apiUrl = 'http://localhost:8050/api/login_check';

  constructor(private http: HttpClient) {}

  login(credentials: { username: string; password: string }): Observable<any> {
    return this.http.post<any>(this.apiUrl, credentials).pipe(
      tap(response => {
        // Si Symfony nos devuelve el token, lo guardamos en el navegador
        if (response.token) {
          localStorage.setItem('token', response.token);
        }
      })
    );
  }

  // Método para cerrar sesión
  logout(): void {
    localStorage.removeItem('token');
  }
}