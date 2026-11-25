import { ValidatorFn } from '@angular/forms';

// Перевіряємо довжину очищеного номера, а не кількість пробілів.
export const validNumber: ValidatorFn = control => {
  const value = String(control.value ?? '').trim();
  return value.length >= 1 && value.length <= 10
    ? null : { numberLength: true };
};

// required окремо перевіряє порожнє числове поле.
export const integer: ValidatorFn = control => {
  return control.value === null || Number.isInteger(control.value)
    ? null : { integer: true };
};

// Не більше двох знаків після коми (перевірка в копійках).
export const maxTwoDecimals: ValidatorFn = control => {
  const value = control.value;
  if (value === null || typeof value !== 'number') return null;
  const cents = value * 100;
  return Math.abs(cents - Math.round(cents)) < 1e-6
    ? null : { decimals: true };
};
