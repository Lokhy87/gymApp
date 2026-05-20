import {
  ChangeDetectorRef,
  Component,
  OnInit,
  AfterViewInit
} from '@angular/core';

import {
  ReactiveFormsModule,
  FormGroup,
  FormControl
} from '@angular/forms';

import { Chart } from 'chart.js/auto';

import { ExerciseService }
from '../../services/exercises';

import {
  ProgressService
} from '../../services/progress.service';

@Component({
  selector: 'app-progress',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './progress.html',
  styleUrl: './progress.css',
})

export class Progress
implements OnInit, AfterViewInit {

  exercises: any[] = [];

  loading = true;

  chart: Chart | null = null;

  reactiveForm =
    new FormGroup({

      searchType:
        new FormControl(''),

      range:
        new FormControl('6')
    });

  constructor(
    private exerciseService:
      ExerciseService,

    private progressService:
      ProgressService,

    private cdr:
      ChangeDetectorRef
  ) {}

  ngOnInit() {

    this.exerciseService
      .getExercises()
      .subscribe(data => {

        this.exercises = data;

        this.loading = false;

        this.cdr.detectChanges();
      });
  }

  ngAfterViewInit() {
    this.createChart([], []);
  }

  onSubmit() {

    const exercise =
      this.reactiveForm
        .value.searchType;

    const months =
      this.reactiveForm
        .value.range;

    if (!exercise || !months) {
      return;
    }

    this.progressService
      .getProgress(
        exercise,
        months
      )
      .subscribe({

        next: (data) => {

          const labels =
            data.map(d =>
              d.date
            );

          const weights =
            data.map(d =>
              d.weight
            );

          this.createChart(
            labels,
            weights
          );
        },

        error: err =>
          console.error(
            err
          )
      });
  }

  createChart(
    labels: string[],
    data: number[]
  ) {

    if (this.chart) {
      this.chart.destroy();
    }

    const canvas =
      document.getElementById(
        'myChart'
      ) as HTMLCanvasElement;

    this.chart =
      new Chart(canvas, {

        type: 'line',

        data: {
          labels,

          datasets: [{
            label:
              'Progress (kg)',

            data,

            borderColor:
              '#00535c',

            borderWidth: 3,

            pointBackgroundColor:
              '#00535c',

            fill: true,

            backgroundColor:
              'rgba(0,125,139,0.48)',

            tension: 0.3
          }]
        },

        options: {

          maintainAspectRatio:
            false,

          scales: {

            x: {
              ticks: {
                color:
                  'white'
              },

              grid: {
                color:
                  'rgba(255,255,255,.45)'
              }
            },

            y: {
              ticks: {
                color:
                  'white'
              },

              grid: {
                color:
                  'rgba(255,255,255,.45)'
              }
            }
          }
        }
      });
  }
}