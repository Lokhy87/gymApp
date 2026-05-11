import { ChangeDetectorRef, Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Card } from '../../shared/components/card/card';
import { ExerciseService } from '../../services/exercises';

@Component({
  selector: 'app-exercises',
  standalone: true,
  imports: [RouterLink, Card],
  templateUrl: './exercises.html',
  styleUrl: './exercises.css',
})
export class Exercises {
  groupId!: number;
  exercises: any[] = [];

  //https://stackoverflow.com/questions/45997369/how-to-get-param-from-url-in-angular-4//
  constructor(private route: ActivatedRoute, private exerciseService: ExerciseService, private cdr:ChangeDetectorRef) {}

  loading = true;

  ngOnInit() {
    this.route.queryParams.subscribe(params => { //Coger parametros del url para mostrar los ejercicios correctos//
      this.groupId = Number(params['group']); //Convertir string a number

      this.loadExercises();
    })
  }

  loadExercises() {
    this.exerciseService.getExercises().subscribe(data => {
      this.exercises = data.filter(
        exercise => exercise.muscle_group_id === this.groupId
      );
      this.loading = false;
      this.cdr.detectChanges();
    });
  }

  openExerciseModal(exercise: string) {
    console.log('open Modal for: ', exercise);
  }

}
