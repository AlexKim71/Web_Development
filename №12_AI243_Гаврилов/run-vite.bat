@echo off
REM CRM Фотоссесій - Запуск Vite (Asset bundler)

echo.
echo ================================
echo CRM Фотоссесій - Vite Dev Server
echo ================================
echo.

if not exist package.json (
    echo Помилка: package.json не знайден!
    echo Спочатку запустіть install.bat
    pause
    exit /b 1
)

echo Запуск Vite development сервера...
echo Натисніть Ctrl+C для зупинення
echo.

call npm run dev

