import { Component, computed, inject, OnInit, signal } from '@angular/core';
import { firstValueFrom } from 'rxjs';
import { RoomsApiService } from './rooms-api.service';
import { ROOM_CATEGORIES, Room, RoomInput } from './room';
import { RoomFormComponent } from './room-form';
import { RoomItemComponent } from './room-item';
import { apiError } from './api-error';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RoomFormComponent, RoomItemComponent],
  templateUrl: './app.html'
})
export class App implements OnInit {
  private readonly api = inject(RoomsApiService);

  readonly categories = ROOM_CATEGORIES;

  readonly rooms = signal<Room[]>([]);
  readonly pending = signal(false);
  readonly loading = signal(false);
  readonly error = signal('');
  readonly message = signal('');
  readonly resetToken = signal(0);

  // Пошук, фільтри та сортування — окремі signals.
  readonly query = signal('');
  readonly category = signal('');          // '' — усі категорії
  readonly availability = signal('all');   // all | available | unavailable
  readonly sortMode = signal('none');      // none | asc | desc

  readonly visible = computed(() => {
    const q = this.query().trim().toLocaleLowerCase('uk-UA');
    const category = this.category();
    const availability = this.availability();
    const rows = this.rooms().filter(r =>
      r.number.toLocaleLowerCase('uk-UA').includes(q)
      && (category === '' || r.category === category)
      && (availability === 'all'
        || (availability === 'available') === r.isAvailable));
    const sort = this.sortMode();
    if (sort === 'asc') {
      return [...rows].sort((a, b) => a.pricePerNight - b.pricePerNight);
    }
    if (sort === 'desc') {
      return [...rows].sort((a, b) => b.pricePerNight - a.pricePerNight);
    }
    return rows;
  });

  // Сумарна місткість доступних кімнат серед видимих.
  readonly availableCapacity = computed(() =>
    this.visible()
      .filter(r => r.isAvailable)
      .reduce((sum, r) => sum + r.capacity, 0));

  ngOnInit(): void { void this.load(); }

  async load(): Promise<void> {
    if (this.pending()) return;
    this.pending.set(true);
    this.loading.set(true);
    this.error.set('');
    this.message.set('');
    try {
      const rows = await firstValueFrom(this.api.list());
      if (!Array.isArray(rows)) throw new Error('API не повернуло масив.');
      this.rooms.set(rows);
    } catch (error) {
      this.error.set(apiError(error));
    } finally {
      this.loading.set(false);
      this.pending.set(false);
    }
  }

  async add(input: RoomInput): Promise<void> {
    if (this.pending()) return;
    this.pending.set(true);
    this.error.set('');
    this.message.set('');
    try {
      const created = await firstValueFrom(this.api.add(input));
      // Беремо саме відповідь сервера, що містить створений id.
      this.rooms.update(rows => [...rows, created]);
      this.resetToken.update(value => value + 1);
      this.message.set('Номер додано.');
    } catch (error) {
      this.error.set(apiError(error));
    } finally {
      this.pending.set(false);
    }
  }

  async remove(room: Room): Promise<void> {
    if (this.pending()
        || !window.confirm(`Видалити номер ${room.number}?`)) {
      return;
    }
    this.pending.set(true);
    this.error.set('');
    this.message.set('');
    try {
      await firstValueFrom(this.api.remove(room.id));
      this.rooms.update(rows => rows.filter(r => r.id !== room.id));
      this.message.set('Номер видалено.');
    } catch (error) {
      this.error.set(apiError(error));
    } finally {
      this.pending.set(false);
    }
  }
}
