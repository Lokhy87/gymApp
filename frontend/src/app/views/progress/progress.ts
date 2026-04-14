import { Component, ViewChild, ElementRef, AfterViewInit } from '@angular/core';
import { Chart } from 'chart.js/auto';

@Component({
  selector: 'app-progress',
  imports: [],
  templateUrl: './progress.html',
  styleUrl: './progress.css',
})
export class Progress implements AfterViewInit {
@ViewChild('chartCanvas') chartCanvas!: ElementRef;

  chart: any;

  selectedExercise = 'curls';
  range = '6';

  ngAfterViewInit() {
    this.createChart();
  }

  createChart() {
    this.chart = new Chart(this.chartCanvas.nativeElement, {
      type: 'line',
      data: {
        labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
          label: 'Curls (kg)',
          data: [20, 22.5, 25, 27.5, 30, 32.5],
          tension: 0.3,
          borderWidth: 2,
          borderColor: '#01a8bc',
          pointBackgroundColor: '#01a8bc',
          fill: true,
          backgroundColor: 'rgba(1, 168, 188, 0.1)'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: {
              color: 'white'
            }
          }
        },
        scales: {
          x: {
            ticks: { color: 'white' },
            grid: { color: 'rgba(255,255,255,0.1)' }
          },
          y: {
            ticks: { color: 'white' },
            grid: { color: 'rgba(255,255,255,0.1)' }
          }
        }
      }
    });
  }

  updateChart() {
    if(!this.chart) return;
    // replace w/ real data
    const newData = this.getFakeData();

    this.chart.data.datasets[0].data = newData;
    this.chart.update();
  }

  getFakeData() {
    if (this.range === '3') return [25, 27, 28];
    if (this.range === '6') return [20, 22, 25, 27, 30, 32];
    return [15, 18, 20, 22, 25, 28, 30, 32, 34, 36, 38, 40];
  }
}
