# Лабораторна робота №6 — Використання Angular в ASP.NET Core

Дисципліна: «Веб-технології та веб-дизайн». Варіант 4 — «Готель — номерний фонд».

Структура:

- `AngularApi/` — ASP.NET Core Web API (.NET 10), маршрут `/api/rooms`;
- `client/` — Angular 21 (standalone-компоненти, signals, Reactive Forms, HttpClient).

## Версії (заповніть фактичними)

| Засіб | Версія |
|-------|--------|
| .NET SDK | `dotnet --version` |
| Node.js | `node --version` |
| npm | `npm.cmd --version` |
| Angular CLI | `npx.cmd ng version` |

## Запуск

Термінал 1 (каталог `Lab6`) або F5 у Visual Studio (профіль `http`, порт 5080):

```powershell
dotnet run --project AngularApi --no-launch-profile --urls http://localhost:5080
```

Термінал 2 (каталог `Lab6/client`):

```powershell
npm.cmd start -- --proxy-config proxy.conf.json --port 4200
```

Клієнт: <http://localhost:4200>. Пряма перевірка API: <http://localhost:5080/api/rooms>.

## Збірка

```powershell
dotnet build AngularApi
cd client
npm.cmd run build
```

На іншому комп'ютері залежності відновлюються командою `npm.cmd ci`
(каталог `client`). Папки `node_modules`, `.angular`, `bin`, `obj`, `dist`
у репозиторій не додають.

## Порти

- API — `http://localhost:5080`;
- Angular CLI — `http://localhost:4200` (проксі `/api/**` → `:5080`).

## Зберігання даних

Дані зберігаються лише в пам'яті серверного процесу (статичний список із
`lock`). Після перезапуску API повертаються початкові 10 кімнат; F5 у
браузері дані сервера не змінює.

## Часовий пояс

У варіанті 4 немає полів дати й часу, тому правила перетворення часових поясів
не застосовуються.

## Правила перевірки

- номер — унікальний (без урахування регістру й крайових пробілів), 1–10 символів;
- категорія — Стандарт, Комфорт, Сімейний, Люкс;
- місткість — 1–8; поверх — 0–50; вартість ночі — 1–100000 грн, не більше двох знаків після коми;
- відповіді API: 200 — успіх, 400 — некоректні дані, 404 — невідомий id, 409 — повтор номера.
