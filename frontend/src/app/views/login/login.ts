import { Component } from '@angular/core';
import { RouterLink, Router } from '@angular/router'; // Añadimos Router para redirigir
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth'; // Ajusta la ruta a tu carpeta services

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [RouterLink, FormsModule],
  templateUrl: './login.html',
  styleUrl: './login.css',
})
export class Login {
  loginData = {
    username: '',
    password: '',
    remember: false
  };

  // Inyectamos el servicio de auth y el router
  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  onLogin() {
    console.log('Iniciando proceso de login...', this.loginData);

    this.authService.login(this.loginData).subscribe({
      next: (response) => {
        console.log('¡Login exitoso!', response);
        // Si el login es correcto, redirigimos a la vista de músculos
        this.router.navigate(['/home']); 
      },
      error: (err) => {
        console.error('Error en el login:', err);
        alert('Credenciales incorrectas o error de servidor');
      }
    });
  }
}