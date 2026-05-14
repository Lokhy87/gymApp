//https://fullcalendar.io/docs/angular//
//https://fullcalendar.io/docs/handleWindowResize//
import { ChangeDetectorRef, Component } from '@angular/core';
import { FullCalendarModule } from '@fullcalendar/angular';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';


@Component({
  selector: 'app-history',
  imports: [FullCalendarModule],
  templateUrl: './history.html',
  styleUrl: './history.css',
})
export class History {

  constructor(private cdr: ChangeDetectorRef) {}

  calendarOptions: any = {
    plugins: [dayGridPlugin, interactionPlugin, listPlugin],
    initialView: window.innerWidth < 1100 ? 'listWeek' : 'dayGridMonth',
    handleWindowResize: true,
    windowResizeDelay: 100,
    windowResize: (view: any) => {
    const newView = window.innerWidth < 1100 ? 'listWeek' : 'dayGridMonth';
    if (view.view.type !== newView) {
      view.view.calendar.changeView(newView);
    }
    },
    dateClick: (info: any) => {
      console.log(info.dateStr);
      this.onDateClick(info.dateStr);
    },
    eventClick: (info: any) => {
      this.onDateClick(info.event.startStr.split('T')[0]);
    },

    events: [
      {
        title: 'Curls',
        date: '2026-05-01'
      },
      {
        title: 'Bench Press',
        date: '2026-05-01'
      },
      {
        title: 'Deadlift',
        date: '2026-05-05'
      }
    ]
  }

  selectedDate: string = '';
  showModal: boolean = false;

  selectedExercises: any[] = [];

  mockData: any = {
    '2026-05-01': [
      { name: 'curls', sets: 3, reps: 10 },
      { name: 'Bench Press', sets: 4, reps: 8 }
    ],
    '2026-05-05': [
      { name: 'Deadlift', sets: 5, reps: 7 }
    ]
  }

  onDateClick(date: string) {
    this.selectedDate = date;
    this.selectedExercises = this.mockData[date] || [];
    this.showModal = true;
    this.cdr.detectChanges();
  }

  closeModal() {
    this.showModal = false;
  }
}
