import { ApplicationConfig } from '@angular/core';
import { provideRouter } from '@angular/router';
import { provideHttpClient, withInterceptors } from '@angular/common/http'; 

import { routes } from './app.routes';
// Importamos la función del interceptor que creaste en la carpeta
import { authInterceptor } from './interceptors/auth-interceptor'; 

export const appConfig: ApplicationConfig = {
  providers: [
    // Configura las rutas de la aplicación
    provideRouter(routes),
    
    // Configura el cliente HTTP para que pase TODAS las peticiones
    // a través de nuestro interceptor de seguridad
    provideHttpClient(
      withInterceptors([authInterceptor])
    )
  ]
};