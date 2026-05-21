# 🚀 Інструкція встановлення Laravel CRM

## Вимоги

- **PHP 8.2+** - [Завантажити](https://www.php.net/downloads)
- **Composer** - [Завантажити](https://getcomposer.org/)
- **Node.js** - [Завантажити](https://nodejs.org/)
- **Git** (опціонально) - [Завантажити](https://git-scm.com/)

## Крок за кроком на Windows

### 1️⃣ Перевірка встановлених програм

Відкрийте PowerShell і перевірте версії:

```bash
php -v
composer -v
node -v
npm -v
```

Якщо якась команда не знайдена, встановіть програму за посиланням вище.

### 2️⃣ Перехід в папку проекту

```bash
cd C:\Users\gavry\Desktop\№12_AI243_Гаврилов\crm-panel
```

### 3️⃣ Встановлення PHP залежностей

```bash
composer install
```

Це займе кілька хвилин. Composer завантажить всі необхідні пакети.

### 4️⃣ Встановлення Node.js залежностей

```bash
npm install
```

### 5️⃣ Копіювання конфіг файлу

```bash
cp .env.example .env
```

На Windows Powershell:
```bash
Copy-Item .env.example .env
```

### 6️⃣ Генерація ключа додатку

```bash
php artisan key:generate
```

Після цього у файлі `.env` буде встановлено значення `APP_KEY`.

### 7️⃣ Створення базу даних

SQLite буде створена автоматично при першій міграції.

Якщо ви використовуєте MySQL, відредагуйте `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_panel
DB_USERNAME=root
DB_PASSWORD=
```

### 8️⃣ Запуск міграцій

```bash
php artisan migrate
```

Це створить всі таблиці в базі даних.

### 9️⃣ Завантаження розширень для ролей

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 🔟 Запуск сівача ролей

```bash
php artisan db:seed RoleSeeder
```

Це створить ролі (admin, manager, client) та дозволи.

### 1️⃣1️⃣ Запуск розробницького сервера

Відкрийте два термінали PowerShell.

**Термінал 1 - Запуск Laravel сервера:**
```bash
php artisan serve
```

Вихід буде схожий:
```
   INFO  Server running on http://127.0.0.1:8000
```

**Термінал 2 - Запуск Vite (Asset bundler):**
```bash
npm run dev
```

### 1️⃣2️⃣ Відкриття додатку в браузері

Відкрийте браузер і перейдіть на: **http://localhost:8000**

## 📝 Створення тестових облікових записів

Після встановлення створіть облікові записи:

### Через Tinker (PHP REPL)

```bash
php artisan tinker
```

```php
$admin = \App\Models\User::create([
    'name' => 'Адміністратор',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
$admin->assignRole('admin');

$manager = \App\Models\User::create([
    'name' => 'Менеджер',
    'email' => 'manager@example.com',
    'password' => bcrypt('password'),
    'role' => 'manager',
]);
$manager->assignRole('manager');

$client = \App\Models\User::create([
    'name' => 'Клієнт',
    'email' => 'client@example.com',
    'password' => bcrypt('password'),
    'role' => 'client',
]);
$client->assignRole('client');

exit
```

## 🔑 Облікові дані для входу

| Роль | Email | Пароль |
|------|-------|--------|
| 🔐 Адміністратор | admin@example.com | password |
| 👨‍💼 Менеджер | manager@example.com | password |
| 👤 Клієнт | client@example.com | password |

## 🛠️ Корисні команди

### Очищення кешу
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Перезапуск БД (видалить всі дані!)
```bash
php artisan migrate:fresh --seed
```

### Запуск тестів
```bash
php artisan test
```

### Форматування коду
```bash
composer pint
```

## ❌ Вирішення проблем

### Помилка: "No application encryption key has been specified"
**Рішення:** Запустіть `php artisan key:generate`

### Помилка: "SQLSTATE[HY000]: General error"
**Рішення:** Перевірте, що папка `storage/` та `bootstrap/cache/` мають права на запис:
```bash
chmod -R 775 storage bootstrap/cache
```

### Помилка при запуску npm
**Рішення:** Видаліть `node_modules` та переінсталюйте:
```bash
rm -r node_modules
npm install
```

### Порт 8000 вже займет
**Рішення:** Запустіть на іншому порту:
```bash
php artisan serve --port=8001
```

## 📁 Структура файлів після встановлення

```
crm-panel/
├── app/                    # Основний код додатку
├── bootstrap/              # Завантажувач додатку
├── config/                 # Конфіг файли
├── database/               # Міграції та сівачі
├── public/                 # Публічні файли
├── resources/              # Шаблони Blade
├── routes/                 # Маршрути
├── storage/                # Сховище файлів
├── vendor/                 # Залежності Composer
├── node_modules/           # Залежності NPM
├── .env                    # Конфіг (створений)
├── composer.json           # Залежності PHP
├── package.json            # Залежності Node
└── README.md              # Документація
```

## 🎉 Успіх!

Якщо ви побачили екран адміністративної панелі - все встановлено правильно!

## 📞 Підтримка

Якщо виникли проблеми, перегляньте:
- [Laravel документація](https://laravel.com/docs)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Larvel Breeze](https://laravel.com/docs/breeze)

---

**Автор:** Гаврилов О.В.  
**Дата:** Травень 2024

