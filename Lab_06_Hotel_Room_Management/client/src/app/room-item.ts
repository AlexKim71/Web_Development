import { Component, computed, input, output } from '@angular/core';
import { Room } from './room';

@Component({
  selector: 'app-room-item',
  standalone: true,
  template: `
    <article>
      <div>
        <strong>Номер {{ room().number }}</strong>
        <p>{{ room().category }} · {{ room().capacity }} ос. · поверх {{ room().floor }}</p>
        <p>{{ price() }} грн / ніч</p>
        <p>
          <span class="badge" [class.off]="!room().isAvailable">
            {{ room().isAvailable ? 'Доступний' : 'Недоступний' }}
          </span>
        </p>
      </div>
      <button type="button" [disabled]="disabled()"
        [attr.aria-label]="'Видалити номер ' + room().number"
        (click)="removed.emit(room())">Видалити</button>
    </article>
  `
})
export class RoomItemComponent {
  readonly room = input.required<Room>();
  readonly disabled = input(false);
  readonly removed = output<Room>();

  readonly price = computed(() =>
    this.room().pricePerNight.toLocaleString('uk-UA', {
      minimumFractionDigits: 2, maximumFractionDigits: 2
    }));
}
