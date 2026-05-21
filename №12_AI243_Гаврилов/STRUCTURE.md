# 📁 Структура проекту Laravel CRM

## Створені файли та голови структури

### 📝 Головні документи
| Файл | Опис |
|------|-----|
| `README.md` | Повна документація проекту |
| `INSTALL.md` | Крок за кроком інструкція встановлення |
| `.env.example` | Приклад конфіг файлу |
| `.gitignore` | Git ignore правила |

### 🔐 Конфіг файли
```
config/
├── app.php           # Основна конфіг додатку
├── auth.php          # Аутентифікація конфіг
└── database.php      # Налаштування БД
```

### 📱 Моделі (app/Models/)
```
app/Models/
├── User.php          # Модель користувача
├── Client.php        # Модель клієнта
└── PhotoSession.php  # Модель фотоссесії
```

### 🎮 Контролери (app/Http/Controllers/)
```
app/Http/Controllers/
├── ClientController.php         # CRUD клієнтів
├── PhotoSessionController.php   # CRUD фотоссесій
├── DashboardController.php      # Дашбоард
├── ProfileController.php        # Профіль користувача
└── auth/                        # Auth контролери (Breeze)
```

### 🔓 Middleware (app/Http/Middleware/)
```
app/Http/Middleware/
└── RoleMiddleware.php  # Перевірка ролей
```

### 📋 Запити валідації (app/Http/Requests/)
```
app/Http/Requests/
└── ProfileUpdateRequest.php  # Валідація профіля
```

### 🗄️ Міграції (database/migrations/)
```
database/migrations/
├── 2024_01_01_000001_create_clients_table.php
├── 2024_01_01_000002_create_photo_sessions_table.php
└── 2024_01_01_000003_add_role_to_users_table.php
```

### 🌱 Сівачі (database/seeders/)
```
database/seeders/
└── RoleSeeder.php  # Створення ролей та дозволів
```

### 🛣️ Маршрути (routes/)
```
routes/
├── web.php   # Web маршрути (основні)
└── auth.php  # Auth маршрути (Breeze)
```

### 🎨 Шаблони Blade (resources/views/)
```
resources/views/
├── layouts/
│   └── app.blade.php                # Основний layout
├── dashboard.blade.php              # Дашбоард сторінка
├── clients/
│   ├── index.blade.php              # Список клієнтів
│   ├── create.blade.php             # Форма додавання
│   ├── edit.blade.php               # Форма редагування
│   └── show.blade.php               # Деталі клієнта
└── photo-sessions/
    ├── index.blade.php              # Список сесій
    ├── create.blade.php             # Форма додавання
    ├── edit.blade.php               # Форма редагування
    └── show.blade.php               # Деталі сесії
```

### 🚀 Інший код (app/)
```
app/
├── Http/
│   └── Kernel.php       # HTTP ядро
├── Providers/
│   └── AppServiceProvider.php  # Service provider
└── bootstrap/
    └── app.php          # Завантажувач додатку
```

### 📦 Залежності
| Файл | Опис |
|------|-----|
| `composer.json` | PHP залежності |
| `package.json` | Node.js залежності |

### 🌐 Public
```
public/
└── index.php  # Entry point додатку
```

## 📊 Статистика файлів

- **PHP файлів:** 15+
- **Blade шаблонів:** 8+
- **Конфіг файлів:** 3
- **Міграцій:** 3
- **Middleware:** 1
- **Controllers:** 4+
- **Models:** 3
- **Total:** 40+ файлів

## 🗂️ Всього папок

```
crm-panel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Kernel.php
│   ├── Models/
│   ├── Providers/
│   └── bootstrap/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── clients/
│       └── photo-sessions/
├── routes/
├── storage/
└── vendor/ (після composer install)
```

## ✨ Особливості реалізації

### ✅ Архітектура
- **MVC архітектура** - Моделі, Контролери, Views
- **RESTful API** - Resource controllers
- **Middleware** - Перевірка ролей та прав
- **ORM (Eloquent)** - Робота з БД

### 🔐 Безпека
- **CSRF захист** - Автоматичні токени
- **SQL injection захист** - Bindings та параметризовані запити
- **Валідація** - Клієнтська і серверна
- **Хешування паролей** - bcrypt алгоритм

### 🎨 Frontend
- **Bootstrap 5** - Responsive grid система
- **Alpine.js** - Мінімальний JS фреймворк
- **FontAwesome** - Іконки
- **Blade шаблони** - Логіка у шаблонах

### 🗄️ База даних
- **SQLite** (за замовчуванням) або MySQL
- **Soft deletes** - логічне видалення
- **Каскадне видалення** - Автоматичне видалення зв'язків
- **NULL constraints** - Обов'язкові поля

## 🚀 Розшираність

Проект написаний з урахуванням можливості легкого розширення:
- Додавання нових моделей
-創ення нових контролерів
- Додавання нових ролей
- Інтеграція з API
- Додавання нових фіч

## 📝 Команди для розробки

```bash
# Запуск сервера
php artisan serve

# Запуск dev server
npm run dev

# Створення моделі з міграцією
php artisan make:model ModelName -m

# Створення контролера
php artisan make:controller ControllerName

# Запуск міграцій
php artisan migrate

# Повернення останньої міграції
php artisan migrate:rollback

# Очищення кешу
php artisan cache:clear
```

---

**Автор:** Гаврилов О.В.  
**Дата:** Травень 2024  
**Всього файлів:** 40+

