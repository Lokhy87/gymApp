import {
  ChangeDetectorRef,
  Component,
  OnInit
} from '@angular/core';

import { FormsModule } from '@angular/forms';
import { FullCalendarModule } from '@fullcalendar/angular';

import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';

import {
  HistoryService,
  WorkoutHistory,
  UpdateWorkoutRequest
} from '../../services/history.service';

@Component({
  selector: 'app-history',
  standalone: true,
  imports: [
    FullCalendarModule,
    FormsModule
  ],
  templateUrl: './history.html',
  styleUrl: './history.css',
})
export class History implements OnInit {

  constructor(
    private cdr: ChangeDetectorRef,
    private historyService: HistoryService
  ) { }

  selectedDate = '';
  showModal = false;

  workouts: WorkoutHistory[] = [];
  selectedExercises: WorkoutHistory[] = [];

  showEditModal = false;
  selectedWorkout: WorkoutHistory | null = null;

  // 👉 formulario simple (template-driven)
  editForm: UpdateWorkoutRequest = {
    sets: 0,
    reps: 0,
    weight: 0,
    comments: ''
  };

  calendarOptions: any = {
    plugins: [dayGridPlugin, interactionPlugin, listPlugin],
    initialView: window.innerWidth < 1100 ? 'listWeek' : 'dayGridMonth',
    handleWindowResize: true,
    windowResizeDelay: 100,

    windowResize: (view: any) => {
      const newView =
        window.innerWidth < 1100 ? 'listWeek' : 'dayGridMonth';

      if (view.view.type !== newView) {
        view.view.calendar.changeView(newView);
      }
    },

    dateClick: (info: any) => {
      this.onDateClick(info.dateStr);
    },

    eventClick: (info: any) => {
      this.onDateClick(info.event.startStr.split('T')[0]);
    },

    events: []
  };

  ngOnInit(): void {
    this.loadHistory();
  }

  loadHistory(): void {
    this.historyService.getHistory().subscribe({
      next: (data) => {
        this.workouts = data;

        this.calendarOptions.events = data.map(w => ({
          title: w.exercise_name,
          date: w.date.split(' ')[0]
        }));

        this.cdr.detectChanges();
      },
      error: (err) => {
        console.error('History error', err);
      }
    });
  }

  onDateClick(date: string): void {
    this.selectedDate = date;

    this.selectedExercises = this.workouts.filter(
      w => w.date.split(' ')[0] === date
    );

    this.showModal = true;
    this.cdr.detectChanges();
  }

  closeModal(): void {
    this.showModal = false;
  }

  openEditModal(workout: WorkoutHistory): void {
    this.selectedWorkout = structuredClone(workout);

    this.showEditModal = true;
    this.cdr.detectChanges();
  }

  closeEditModal(): void {
    this.showEditModal = false;
    this.selectedWorkout = null;
  }

  saveEdit(): void {
    if (!this.selectedWorkout) return;

    const payload = {
      sets: this.selectedWorkout.sets,
      reps: this.selectedWorkout.reps,
      weight: this.selectedWorkout.weight,
      comments: this.selectedWorkout.comments
    };

    this.historyService.updateWorkout(this.selectedWorkout.id, payload)
      .subscribe({
        next: () => {

          // 1. cerrar modal edición
          this.showEditModal = false;
          this.selectedWorkout = null;

          // 2. refrescar datos
          this.historyService.getHistory().subscribe({
            next: (data) => {

              this.workouts = data;

              this.calendarOptions = {
                ...this.calendarOptions,
                events: data.map(w => ({
                  title: w.exercise_name,
                  date: w.date.split(' ')[0]
                }))
              };

              // 3. 🔥 cerrar modal principal también
              this.showModal = false;
              this.selectedExercises = [];
              this.selectedDate = '';

              this.cdr.detectChanges();
            }
          });
        },
        error: err => console.error('Update error', err)
      });
  }

  deleteWorkout(workout: WorkoutHistory): void {
    const confirmed = confirm(
      `Delete ${workout.exercise_name}?`
    );

    if (!confirmed) return;

    this.historyService.deleteWorkout(workout.id).subscribe({
      next: () => {
        this.selectedExercises =
          this.selectedExercises.filter(w => w.id !== workout.id);

        this.loadHistory();
        this.cdr.detectChanges();
      },
      error: (err) => {
        console.error('Delete error', err);
      }
    });
  }
}