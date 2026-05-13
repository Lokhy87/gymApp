import { Component, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-modal',
  imports: [],
  templateUrl: './modal.html',
  styleUrl: './modal.css',
})
export class Modal {

  @Input() title: string = '';
  @Input() isVisible: boolean = false;

  @Output() closed = new EventEmitter<void>();

  public onClose(): void {
    this.closed.emit();
  }
}