import { Component } from '@angular/core';
import { RouterLink, Router } from '@angular/router'; 
import { FormsModule } from '@angular/forms'; // 1. Mantenemos el import de TS
import { AuthService } from '../../services/auth'; 

@Component({
  selector: 'app-register',
  standalone: true, // Asegúrate de tener esta línea si usas Angular moderno
  imports: [RouterLink, FormsModule], // 2. ¡SOLUCIÓN! Añadimos FormsModule al motor del componente
  templateUrl: './register.html',
  styleUrl: './register.css',
})
export class Register {
  registerData = {
    username: '',
    email: '',
    password: '',
    location: 'Valencia' 
  };

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  onRegister(): void {
    console.log('Enviando datos a la API:', this.registerData);

    this.authService.register(this.registerData).subscribe({
      next: (response: any) => { // Añadimos : any para evitar quejas de TsConfig
        console.log('¡Usuario guardado en MySQL!', response);
        alert('Account created successfully!');
        this.router.navigate(['/login']);
      },
      error: (err: any) => { // Añadimos : any para evitar quejas de TsConfig
        console.error('Error al insertar en la BBDD:', err);
        alert('Registration failed. Check if email already exists.');
      }
    });
  }
}