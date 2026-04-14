import { Component } from '@angular/core';
import { FullCalendarModule } from '@fullcalendar/angular';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

@Component({
  selector: 'app-history',
  imports: [FullCalendarModule],
  templateUrl: './history.html',
  styleUrl: './history.css',
})
export class History {

  calendarOptions = {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',

    dateClick: (info: any) => {
      console.log('Clicked date:', info.dateStr);
    },

    headerToolbar: {
      left: 'prev,next',
      center: 'title',
      right: ''
    }
  };
}
