import { Component } from '@angular/core';

@Component({
  selector: 'app-profile',
  imports: [],
  templateUrl: './profile.html',
  styleUrl: './profile.css',
})
export class Profile {

  editMode = false;

  user={
    username: 'JohnDoe',
    email: 'john@dummy.com',
    password: 'password123',
    location: 'Spain',
  }

  editProfile() {
    this.editMode = !this.editMode;
  }

  deleteAccount() {
    const confirmDelete = confirm("Are you sure you want to delete your account?");

    if (confirmDelete) {
      console.log("Account Deleted");
    }
  }
}
