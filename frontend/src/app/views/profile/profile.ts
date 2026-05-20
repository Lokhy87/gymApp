import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth';
import { UserProfile } from '../../shared/interfaces/user.interface'; // 👈 IMPORTACIÓN DE LA NUEVA INTERFAZ

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './profile.html',
  styleUrls: ['./profile.css'],
})
export class Profile implements OnInit {
  loading = true;
  editMode = false;

  // Usamos la interfaz importada
  user: UserProfile = {
    username: '',
    name: '',
    email: '',
    location: '',
  };

  constructor(
    private auth: AuthService,
    private cdr: ChangeDetectorRef
  ) { }

  ngOnInit() {
    console.log("Profile INIT - Ruta activada desde el Sidebar");
    this.loadUserData();
  }

  loadUserData() {
    this.loading = true;
    console.log("Disparando GET /api/me...");

    this.auth.getProfile().subscribe({
      next: (profile) => {
        console.log("PROFILE RECEIVED OK:", profile);

        this.user = {
          username: profile.username || '',
          name: profile.name || 'User',
          email: profile.email || '',
          location: profile.location || ''
        };

        localStorage.setItem('userName', this.user.name);
        this.loading = false;
        this.cdr.detectChanges();
      },
      error: (err) => {
        console.warn('No se pudo cargar el perfil', err);
        this.loading = false;
        this.cdr.detectChanges();
      }
    });
  }

  editProfile() {
    this.editMode = !this.editMode;
  }

  saving = false;

  saveProfile() {

    this.saving = true;

    this.auth
      .updateProfile(this.user)
      .subscribe({

        next: (response) => {

          console.log(
            'PROFILE UPDATED',
            response
          );

          // actualizar nombre sidebar
          localStorage.setItem(
            'userName',
            this.user.name
          );

          this.editMode = false;
          this.saving = false;

          this.cdr.detectChanges();
        },

        error: (err) => {

          console.error(
            'Profile update error',
            err
          );

          this.saving = false;
          this.cdr.detectChanges();
        }
      });
  }

  deleteAccount() {
    const confirmDelete = confirm("Are you sure you want to delete your account?");
    if (confirmDelete) {
      console.log("Account Deleted");
    }
  }
}