# CRM Фотоссесій - Laravel

Полнофункціональна CRM система для управління фотоссесіями, клієнтами та фотографами на базі Laravel.

## 🎯 Особливості

✅ **Система авторизації** - Реалізована через Laravel Breeze  
✅ **Ролевий доступ** - Адміністратор, Менеджер (фотограф), Клієнт  
✅ **Управління клієнтами** - CRUD операції з клієнтами  
✅ **Управління фотоссесіями** - Планування та відслідження сесій  
✅ **Адміністративна панель** - Інтуїтивний інтерфейс  
✅ **Захист маршрутів** - Middleware для перевірки прав  
✅ **Сучасний дизайн** - Bootstrap 5 + Alpine.js  

## 📋 Вимоги

- PHP 8.2+
- Composer
- Node.js (для NPM)
- SQLite або MySQL

## 🚀 Встановлення

### 1. Клонування проекту

```bash
cd crm-panel
```

### 2. Встановлення залежностей PHP

```bash
composer install
```

### 3. Встановлення залежностей Node

```bash
npm install
```

### 4. Копіювання файлу конфіг

```bash
cp .env.example .env
```

### 5. Генерація ключа додатку

```bash
php artisan key:generate
```

### 6. Створення БД

```bash
touch database/database.sqlite
```

### 7. Запуск міграцій

```bash
php artisan migrate
```

### 8. Запуск сівача ролей

```bash
php artisan db:seed RoleSeeder
```

### 9. Запуск розробницького сервера

```bash
php artisan serve
```

Відкрийте браузер на http://localhost:8000

## 👤 Облікові записи для тестування

### Адміністратор
- **Email:** admin@example.com
- **Пароль:** password

### Менеджер (Фотограф)
- **Email:** manager@example.com
- **Пароль:** password

### Клієнт
- **Email:** client@example.com
- **Пароль:** password

## 📁 Структура проекту

```
crm-panel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ClientController.php
│   │   │   ├── PhotoSessionController.php
│   │   │   ├── DashboardController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   ├── Requests/
│   │   │   └── ProfileUpdateRequest.php
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Client.php
│   │   └── PhotoSession.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_clients_table.php
│   │   ├── 2024_01_01_000002_create_photo_sessions_table.php
│   │   └── 2024_01_01_000003_add_role_to_users_table.php
│   └── seeders/
│       └── RoleSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── clients/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── photo-sessions/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       └── dashboard.blade.php
├── routes/
│   ├── web.php
│   └── auth.php
├── .env.example
├── .gitignore
├── composer.json
└── README.md
```

## 🔐 Система ролей та прав

### Адміністратор
- Повний доступ до всіх функцій
- Управління клієнтами (CRUD)
- Управління фотоссесіями (CRUD)
- Адміністрування користувачів

### Менеджер (Фотограф)
- Перегляд своїх клієнтів
- Перегляд та редагування своїх фотоссесій
- Редагування статусу сесій
- Не може видаляти записи

### Клієнт
- Перегляд дашбоарду
- Перегляд власних замовлень (за змовчуванням)

## 🗄️ Модель даних

### Таблиця Users
- id (INT)
- name (STRING)
- email (STRING, UNIQUE)
- password (STRING)
- role (STRING) - admin, manager, client
- email_verified_at (TIMESTAMP)
- created_at, updated_at

### Таблиця Clients
- id (INT)
- name (STRING)
- email (STRING, UNIQUE)
- phone (STRING, NULLABLE)
- assigned_manager_id (INT, FK)
- created_at, updated_at

### Таблиця PhotoSessions
- id (INT)
- title (STRING)
- description (TEXT, NULLABLE)
- session_date (DATETIME)
- duration (INT) - в хвилинах
- type (ENUM) - весільна, сімейна, портретна, інші
- status (ENUM) - нові, в процесі, завершено
- client_id (INT, FK)
- manager_id (INT, FK)
- created_at, updated_at

## 🔧 Використані пакети

- **laravel/framework** - Web framework
- **laravel/breeze** - Автентифікація
- **spatie/laravel-permission** - Управління ролями та дозволами
- **bootstrap** - CSS фреймворк
- **alpinejs** - JS фреймворк

## 📝 API Маршрути

### Клієнти
- `GET /clients` - Список клієнтів
- `GET /clients/create` - Форма створення
- `POST /clients` - Додавання
- `GET /clients/{id}` - Деталі
- `GET /clients/{id}/edit` - Форма редагування
- `PATCH /clients/{id}` - Оновлення
- `DELETE /clients/{id}` - Видалення

### Фотоссесії
- `GET /photo-sessions` - Список
- `GET /photo-sessions/create` - Форма створення
- `POST /photo-sessions` - Додавання
- `GET /photo-sessions/{id}` - Деталі
- `GET /photo-sessions/{id}/edit` - Форма редагування
- `PATCH /photo-sessions/{id}` - Оновлення
- `DELETE /photo-sessions/{id}` - Видалення

## 🎨 Дизайн та UX

- Адаптивний дизайн для мобільних, планшетів та ПК
- Современні градієнти и анімації
- Інтуїтивні кнопки та форми
- Темна боковая панель навігації
- Модальні вікна для критичних операцій

## 🤝 Внесення змін

1. Створіть гілку (`git checkout -b feature/AmazingFeature`)
2. Зберегти зміни (`git commit -m 'Add some AmazingFeature'`)
3. Завантажити гілку (`git push origin feature/AmazingFeature`)
4. Відкрити Pull Request

## 📄 Ліцензія

MIT License

## 👨‍💻 Автор

Гаврилов О.В.  
Лабораторна робота №12 - Веб-технології та дизайн  
Варіант 8: CRM для фотоссесій

## 📞 Контакти

Для питань та пропозицій звертатися до автора.

---

**Останнє оновлення:** 2024

