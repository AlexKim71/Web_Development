@echo off
REM CRM Фотоссесій - Встановлення та запуск на Windows

echo.
echo ================================
echo CRM Фотоссесій - Встановлення
echo ================================
echo.

REM Перевірка обов'язкових програм
echo [1/10] Перевірка обов'язкових програм...
php -v >nul 2>&1
if errorlevel 1 (
    echo Помилка: PHP не встановлена!
    pause
    exit /b 1
)

composer -v >nul 2>&1
if errorlevel 1 (
    echo Помилка: Composer не встановлена!
    pause
    exit /b 1
)

node -v >nul 2>&1
if errorlevel 1 (
    echo Помилка: Node.js не встановлена!
    pause
    exit /b 1
)

REM Встановлення PHP залежностей
echo.
echo [2/10] Встановлення PHP залежностей (Composer)...
call composer install

REM Встановлення NPM залежностей
echo.
echo [3/10] Встановлення Node.js залежностей (NPM)...
call npm install

REM Копіювання конфіг файлу
echo.
echo [4/10] Копіювання конфіг файлу...
if exist .env (
    echo .env вже існує
) else (
    copy .env.example .env
    echo .env створен
)

REM Генерація ключа
echo.
echo [5/10] Генерація ключа додатку...
call php artisan key:generate

REM Перевірка та створення БД
echo.
echo [6/10] Перевірка файлу БД...
if not exist database\database.sqlite (
    echo Буде створено SQLite БД...
)

REM Запуск міграцій
echo.
echo [7/10] Запуск міграцій БД...
call php artisan migrate --force

REM Видавлення розширень для ролей
echo.
echo [8/10] Встановлення розширень для ролей...
call php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

REM Запуск сівачів
echo.
echo [9/10] Запуск сівачів...
call php artisan db:seed RoleSeeder

REM Очищення кешу
echo.
echo [10/10] Очищення кешу...
call php artisan cache:clear
call php artisan config:clear

echo.
echo ================================
echo ✓ Встановлення завершено!
echo ================================
echo.
echo Для запуску виконайте:
echo 1. php artisan serve
echo 2. npm run dev
echo.
echo Потім відкрийте: http://localhost:8000
echo.
echo Облікові дані:
echo - Email: admin@example.com
echo - Пароль: password
echo.
pause

