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

  calendarOptions: any = {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
    dateClick: (info: any) => {
      console.log(info.dateStr);
    }
  };
}
