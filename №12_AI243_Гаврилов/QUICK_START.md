# 🚀 Швидкий старт - CRM Фотоссесій

## ⚡ За 5 хвилин до запуску

### На Windows PowerShell

#### 1️⃣ Перейти до проекту
```bash
cd C:\Users\gavry\Desktop\№12_AI243_Гаврилов\crm-panel
```

#### 2️⃣ Запустити встановлення (АБО вручну - дивись нижче)
```bash
.\install.bat
```

**Після завершення натисніть будь-яку клавішу...**

---

## 📋 Ручне встановлення (якщо install.bat не спрацював)

### Крок 1: Встановлення PHP залежностей
```bash
composer install
```

### Крок 2: Встановлення Node залежностей
```bash
npm install
```

### Крок 3: Копіювання конфіг
```bash
cp .env.example .env
```

### Крок 4: Генерація ключа
```bash
php artisan key:generate
```

### Крок 5: Міграції БД
```bash
php artisan migrate
```

### Крок 6: Ролі та дозволи
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
php artisan db:seed RoleSeeder
```

---

## ▶️ Запуск підуключ

### Варіант 1️⃣: Автоматичний запуск

**Термінал 1:**
```bash
.\run-server.bat
```

**Новий окремийTermInал:**
```bash
.\run-vite.bat
```

### Варіант 2️⃣: Ручний запуск

**Термінал 1 - Laravel сервер:**
```bash
php artisan serve
```

**Новий окремий Термінал 2 - Asset bundler:**
```bash
npm run dev
```

### ✅ Успіх!

Відкрийте браузер: **http://localhost:8000**

---

## 🔑 Вхід до системи

| Роль | Email | Пароль |
|------|-------|--------|
| 🔐 Admin | admin@example.com | password |
| 👨‍💼 Manager | manager@example.com | password |
| 👤 Client | client@example.com | password |

---

## 📁 Структура папок

```
crm-panel/
├── app/                    # PHP код
│   ├── Http/
│   │   ├── Controllers/   # Контролери
│   │   └── Middleware/    # Middleware
│   └── Models/            # БД моделі
├── resources/views/       # Blade шаблони
├── database/
│   ├── migrations/        # Міграції БД
│   └── seeders/           # Сівачі
├── routes/                # Маршрути
├── public/                # Публічні файли
├── INSTALL.md             # Детальна інструкція
├── README.md              # Документація
├── install.bat            # Встановлення
├── run-server.bat         # Запуск сервера
└── run-vite.bat          # Запуск Vite
```

---

## 🎨 Функції системи

### Адміністратор може:
- ✅ Керувати клієнтами (CRUD)
- ✅ Керувати фотоссесіями (CRUD)
- ✅ Назначати менеджерів
- ✅ Переглядати статистику

### Менеджер (фотограф) може:
- ✅ Переглядати своїх клієнтів
- ✅ Керувати своїми фотоссесіями
- ✅ Оновлювати статус сесій
- ✅ Переглядати дашбоард

### Клієнт може:
- ✅ Переглядати дашбоард
- ✅ Переглядати свої замовлення

---

## 🛠️ Корисні команди

```bash
# Очищення кешу
php artisan cache:clear

# Перезавантажити БД (видалить ВСІ дані!)
php artisan migrate:fresh --seed

# Запуск на інших портах
php artisan serve --port=8001
```

---

## ⚠️ Частові помилки

### ❌ "No application encryption key"
```bash
php artisan key:generate
```

### ❌ "SQLSTATE[HY000]"
Перевірте права на папки:
```bash
# На Linux/Mac:
chmod -R 775 storage bootstrap
```

### ❌ "Port 8000 already in use"
```bash
php artisan serve --port=8001
```

---

## 📚 Документація

- **README.md** - Повна документація
- **INSTALL.md** - Детальна інструкція встановлення
- **STRUCTURE.md** - Структура проекту

---

## 🤝 Технологічний стек

- **Laravel 11** - Web фреймворк
- **PHP 8.2+** - мова програмування
- **Bootstrap 5** - CSS фреймворк
- **Alpine.js** - JS фреймворк
- **SQLite** - База даних
- **Composer** - PHP менеджер пакетів
- **NPM** - Node менеджер пакетів

---

## 📞 Поддержка

Якщо не виходить:
1. Перевірте версіі PHP, Node, Composer
2. Видаліть `node_modules` та `.composer/cache`
3. Переінсталюйте залежності
4. Перевірте права на папки

---

**Автор:** Гаврилов О.В.  
**ФІ:** Гаврилов О.В.  
**Варіант:** 8 (CRM для фотоссесій)  
**Дата:** Травень 2024

Приємного користування! 🎉

