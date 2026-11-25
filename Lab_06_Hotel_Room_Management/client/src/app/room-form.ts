import {
  Component, input, output, OnChanges, SimpleChanges
} from '@angular/core';
import {
  FormControl, FormGroup, ReactiveFormsModule, Validators
} from '@angular/forms';
import { ROOM_CATEGORIES, RoomInput } from './room';
import { integer, maxTwoDecimals, validNumber } from './room-validators';

@Component({
  selector: 'app-room-form',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './room-form.html'
})
export class RoomFormComponent implements OnChanges {
  readonly disabled = input(false);
  readonly resetToken = input(0);
  readonly saved = output<RoomInput>();

  readonly categories = ROOM_CATEGORIES;

  readonly form = new FormGroup({
    number: new FormControl('', {
      nonNullable: true, validators: [validNumber]
    }),
    category: new FormControl('', {
      nonNullable: true, validators: [Validators.required]
    }),
    capacity: new FormControl<number | null>(null, [
      Validators.required, Validators.min(1), Validators.max(8), integer
    ]),
    floor: new FormControl<number | null>(null, [
      Validators.required, Validators.min(0), Validators.max(50), integer
    ]),
    pricePerNight: new FormControl<number | null>(null, [
      Validators.required, Validators.min(1), Validators.max(100000),
      maxTwoDecimals
    ]),
    isAvailable: new FormControl(true, { nonNullable: true })
  });

  ngOnChanges(changes: SimpleChanges): void {
    // Батьківський компонент змінює token лише після успішного POST.
    if (changes['resetToken'] && !changes['resetToken'].firstChange) {
      this.form.reset({
        number: '', category: '', capacity: null, floor: null,
        pricePerNight: null, isAvailable: true
      });
    }
  }

  submit(): void {
    if (this.disabled()) return;
    this.form.markAllAsTouched();
    if (this.form.invalid) return;
    const raw = this.form.getRawValue();
    if (raw.capacity === null || raw.floor === null
        || raw.pricePerNight === null) return;
    this.saved.emit({
      number: raw.number.trim(),
      category: raw.category,
      capacity: raw.capacity,
      floor: raw.floor,
      pricePerNight: raw.pricePerNight,
      isAvailable: raw.isAvailable
    });
    // Тут форму НЕ очищуємо: сервер ще може відхилити запис.
  }
}
