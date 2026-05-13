import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { Card } from '../../shared/components/card/card';
import { MuscleGroupInterface } from '../../shared/interfaces/muscle-groups.interface';
import { MuscleGroupService } from '../../services/muscle-groups';

@Component({
  selector: 'app-home',
  imports: [RouterLink, Card], templateUrl: './home.html',
  styleUrl: './home.css',
})
export class Home {
  muscleGroups: MuscleGroupInterface[] = [];

  constructor(
    private muscleGroupService: MuscleGroupService,
    private router: Router,
    private cdr: ChangeDetectorRef
  ) { }

  loading = true;

  ngOnInit() {
    this.muscleGroupService.getMuscleGroups().subscribe(data => {
      this.muscleGroups = data;
      this.loading = false;
      this.cdr.detectChanges(); //Have to add this because the API takes a while to respond. This detects changes
      console.log(data);
    })
  }

  //https://stackoverflow.com/questions/45997369/how-to-get-param-from-url-in-angular-4//
  goToExercises(groupId: number) {
    this.router.navigate(['/exercises'], { //https://angular.dev/guide/routing/navigate-to-routes//
      queryParams: { group: groupId } //Almacenar parametro para coger los exercicios correctos
    });
  }

}
