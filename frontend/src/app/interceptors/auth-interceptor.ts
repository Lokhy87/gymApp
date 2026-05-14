import { HttpInterceptorFn } from '@angular/common/http';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  // Intentamos sacar el token del localStorage
  const token = localStorage.getItem('token');

  // Si existe, clonamos la petición y le añadimos el Header Authorization
  if (token) {
    const authReq = req.clone({
      setHeaders: {
        Authorization: `Bearer ${token}`
      }
    });
    return next(authReq);
  }

  // Si no hay token, la petición sigue tal cual
  return next(req);
};