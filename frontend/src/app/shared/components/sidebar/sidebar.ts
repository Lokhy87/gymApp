// src/app/components/sidebar/sidebar.ts

import { Component, OnInit } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { CommonModule } from '@angular/common'; // 👈 IMPORTANTE para el pipe async
import { AuthService } from '../../../services/auth';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-sidebar',
  standalone: true,
  imports: [RouterLink, RouterLinkActive, CommonModule], // 👈 Añadimos CommonModule aquí
  templateUrl: './sidebar.html',
  styleUrl: './sidebar.css',
})
export class Sidebar implements OnInit {
  // En lugar de un string estático, manejamos el flujo reactivo del servicio
  userName$: Observable<string> | undefined;

  constructor(private auth: AuthService) {}

  ngOnInit() {
    // Nos conectamos directamente al flujo de datos del servicio
    this.userName$ = this.auth.userName$;
  }
}