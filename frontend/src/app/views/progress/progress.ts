import { Component } from '@angular/core';
import { Chart } from 'chart.js/auto';
import { ReactiveFormsModule, FormGroup, FormControl} from '@angular/forms';

@Component({
  selector: 'app-progress',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './progress.html',
  styleUrl: './progress.css',
})
export class Progress {
  
  reactiveForm = new FormGroup ({
    searchType: new FormControl(''),
    range: new FormControl(''),
  })
  
  chart: any;

  onSubmit() {
    const searchType = (this.reactiveForm.value.searchType ?? '').toLowerCase();
    const range = (this.reactiveForm.value.range ?? '').toLowerCase();

    console.log('Exercise:', searchType);
    console.log('Range:', range);

    const data = this.getDataBasedOnSelection(searchType, range);

    if (!this.chart) {
      this.createChart();
    }

    this.chart.data.labels = data.labels;
    this.chart.data.datasets[0].data = data.values;

    this.chart.update();
  }

  ngAfterViewInit() {
    this.createChart();
  }

  createChart() {
  const canvas = document.getElementById('myChart') as HTMLCanvasElement;

  this.chart = new Chart(canvas, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        data: [],
        borderColor: '#01a8bc'
      }]
    }
  });
}

  getDataBasedOnSelection(searchType: string | null, range: string | null) {

    if (searchType === 'curls' && range === '6') {
      return {
        labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
        values: [20, 22, 25, 27, 30, 32]
      };
    }

    if (searchType === 'rows') {
      return {
        labels: ['Nov', 'Dec', 'Jan', 'Feb'],
        values: [40, 42, 45, 47]
      };
    }

    if (searchType === 'flies') {
      return {
        labels: ['Nov', 'Dec', 'Jan', 'Feb'],
        values: [10, 12, 13, 15]
      };
    }

    return {
      labels: [],
      values: []
    };
  }
}
