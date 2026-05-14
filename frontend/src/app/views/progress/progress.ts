import { ChangeDetectorRef, Component } from '@angular/core';
import { Chart } from 'chart.js/auto';
import { ReactiveFormsModule, FormGroup, FormControl} from '@angular/forms';
import { ExerciseService } from '../../services/exercises';

@Component({
  selector: 'app-progress',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './progress.html',
  styleUrl: './progress.css',
})
export class Progress {

  exercises: any[] = [];

  constructor(private exerciseService: ExerciseService, private cdr:ChangeDetectorRef) {}

  loading = true;

  ngOnInit() {
    this.exerciseService.getExercises().subscribe(data=> {
      this.exercises=data;
      this.loading = false;
      this.cdr.detectChanges();
      console.log(data);
    })
  }
  
  reactiveForm = new FormGroup ({
    searchType: new FormControl(''),
    range: new FormControl(''),
  })
  
  chart: any;

onSubmit() {
  console.log("hello");
}

ngAfterViewInit() {
  this.createChart();
}

createChart() {
  const canvas = document.getElementById('myChart') as HTMLCanvasElement;

  this.chart = new Chart(canvas, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr',
  'May', 'Jun', 'Jul', 'Aug',
  'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Bench Press (kg)',
        data: [60, 62.5, 65, 67.5, 70, 72.5, 75, 77.5, 80, 82.5, 85, 87.5],
        borderColor: '#00535c',
        borderWidth: 3,
        pointBackgroundColor: '#00535c',
        pointBorderColor: '#00535c',
        fill: true,
        backgroundColor: 'rgba(0, 125, 139, 0.48)',
        tension: 0.3
      }]
    },
    options: {
      maintainAspectRatio: false,
      scales: {
        x: {
          ticks: {
            color: 'white'
          },
          grid: {
            color: 'rgba(255, 255, 255, 0.45)'
          }
        },
        y: {
          ticks: {
            color: 'white'
          },
          grid: {
            color: 'rgba(255, 255, 255, 0.44)'
          }
        }
      }
    }
  });
}


}
