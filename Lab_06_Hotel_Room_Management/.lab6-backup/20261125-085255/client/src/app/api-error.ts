import { HttpErrorResponse } from '@angular/common/http';
import { TimeoutError } from 'rxjs';

export function apiError(error: unknown): string {
  if (error instanceof TimeoutError) {
    return 'Час очікування відповіді минув.';
  }
  if (error instanceof HttpErrorResponse) {
    if (error.status === 0) return 'Сервер або мережа недоступні.';
    const body = error.error;
    if (body && typeof body === 'object') {
      const values = body.errors;
      if (values && typeof values === 'object') {
        const messages = Object.values(values).flat()
          .filter((value): value is string => typeof value === 'string');
        if (messages.length) return messages.join(' ');
      }
      if (typeof body.detail === 'string') return body.detail;
    }
    return `Помилка HTTP ${error.status}. Перевірте запит.`;
  }
  return error instanceof Error ? error.message : 'Невідома помилка.';
}
