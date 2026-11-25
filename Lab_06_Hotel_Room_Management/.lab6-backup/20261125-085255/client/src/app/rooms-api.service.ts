import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, timeout } from 'rxjs';
import { Room, RoomInput } from './room';

@Injectable({ providedIn: 'root' })
export class RoomsApiService {
  private readonly http = inject(HttpClient);
  private readonly url = '/api/rooms';

  // Observable не надсилає запит до моменту підписки.
  list(): Observable<Room[]> {
    return this.http.get<Room[]>(this.url).pipe(timeout(10000));
  }

  add(input: RoomInput): Observable<Room> {
    return this.http.post<Room>(this.url, input).pipe(timeout(10000));
  }

  remove(id: string): Observable<Room> {
    const url = `${this.url}/${encodeURIComponent(id)}`;
    return this.http.delete<Room>(url).pipe(timeout(10000));
  }
}
