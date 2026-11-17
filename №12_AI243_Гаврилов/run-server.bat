@echo off
REM CRM Фотоссесій - Запуск розробницького сервера

echo.
echo ================================
echo CRM Фотоссесій - Запуск
echo ================================
echo.

REM Перевірка файлу .env
if not exist .env (
    echo Помилка: .env файл не знайден!
    echo Спочатку запустіть install.bat
    pause
    exit /b 1
)

REM Отримання номера порту або використання замовчування
if "%1"=="" (
    set PORT=8000
) else (
    set PORT=%1
)

echo.
echo Запуск Laravel сервера на порту %PORT%...
echo Відкрийте браузер: http://localhost:%PORT%
echo.
echo Натисніть Ctrl+C для зупинення
echo.

call php artisan serve --port=%PORT%

