// JSON-контракт: назви властивостей збігаються з відповіддю API (camelCase).
export interface Room {
  id: string;
  number: string;
  category: string;
  capacity: number;
  floor: number;
  pricePerNight: number;
  isAvailable: boolean;
}

// Id не вводять у формі: його створює сервер.
export type RoomInput = Omit<Room, 'id'>;

// Фіксований перелік категорій (збігається з AllowedValues на сервері).
export const ROOM_CATEGORIES = ['Стандарт', 'Комфорт', 'Сімейний', 'Люкс'] as const;
