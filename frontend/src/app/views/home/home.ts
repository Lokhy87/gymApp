import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { Card } from '../../shared/components/card/card';
import { inject } from '@angular/core';

@Component({
  selector: 'app-home',
  imports: [RouterLink, Card],
  templateUrl: './home.html',
  styleUrl: './home.css',
})
export class Home {
  muscleGroups = [
    'Back',
    'Chest',
    'Shoulders',
    'Core',
    'Legs',
    'Arms'
  ];

  private router = inject(Router); //https://angular.dev/guide/routing/navigate-to-routes//

  goToExercises(group: string) {
    this.router.navigate(['/exercises'], { queryParams: { group }});
  }
}
