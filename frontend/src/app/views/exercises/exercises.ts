import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Card } from '../../shared/components/card/card';

@Component({
  selector: 'app-exercises',
  standalone: true,
  imports: [RouterLink, Card],
  templateUrl: './exercises.html',
  styleUrl: './exercises.css',
})
export class Exercises {
  group: string = '';
  exercises:string[] = [];

  constructor(private activatedRoute: ActivatedRoute) { //https://stackoverflow.com/questions/45997369/how-to-get-param-from-url-in-angular-4//
    this.activatedRoute.queryParams.subscribe(params => {
      this.group = params['group'];
    });
  }

  ngOnInit() {
    this.setExercises();
  }  

  setExercises() {
    if (this.group === 'Back') {
      this.exercises = ['Deadlift', 'Barbell Row', 'Pull-Ups', 'Lat Pulldown', 'Cable Row', 'Face Pull'];
    } else if (this.group === 'Chest') {
      this.exercises = ['Bench Press', 'Chest Fly', 'Push-Ups', 'Cable Crossover', 'Dumbbell Press', 'Incline Press'];
    } else if (this.group === 'Shoulders') {
      this.exercises = ['Overhead Press', 'Lateral Raises', 'Front Raises', 'Rear Delt Fly', 'Arnold Press', 'Shrugs'];
    } else if (this.group === 'Arms') {
      this.exercises = ['Bicep Curls', 'Hammer Curls', 'Tricep Pushdown', 'Skullcrusher', 'Dips', 'Preacher Curls'];
    } else if (this.group === 'Legs') {
      this.exercises = ['Squats', 'Leg Press', 'Lunges', 'Romanian Deadlift', 'Leg Curl', 'Calf Raises'];
    } else if (this.group === 'Core') {
      this.exercises = ['Plank', 'Crunches', 'Hanging Leg Raise', 'Russian Twist', 'Bicycle Crunch', 'Side Plank'];
    }
  }

  openExerciseModal(exercise: string) {
    console.log('open Modal for: ', exercise);
  }

}
