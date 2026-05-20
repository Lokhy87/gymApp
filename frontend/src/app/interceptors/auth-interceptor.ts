import {
  HttpInterceptorFn
} from '@angular/common/http';

export const authInterceptor:
HttpInterceptorFn = (
  req,
  next
) => {

  const token =
    localStorage
      .getItem('token')
      ?.trim();

  // Sin token
  if (!token) {
    return next(req);
  }

  // Clonar request
  const authReq =
    req.clone({

      setHeaders: {
        Authorization:
          `Bearer ${token}`
      }
    });

  return next(authReq);
};