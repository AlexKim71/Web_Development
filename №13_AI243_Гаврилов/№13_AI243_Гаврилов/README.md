# my-app - Лабораторна робота №13 (AI243)

Простий веб-додаток на Node.js + Express з чистим фронтенд дизайном.

Вимоги

Node.js 18+ (якщо запускаєте локально)
Docker (якщо використовуєте контейнеризацію)
Git

Запуск локально (без Docker)

Встановити Node.js з https://nodejs.org/

1. Встановити залежності
npm install

2. Запустити сервер
npm start

3. Відкрити http://localhost:3000

Запуск з Docker

1. Збудувати образ
docker build -t my-app .

2. Запустити контейнер
docker run -p 3000:3000 my-app

3. Відкрити http://localhost:3000

Структура проекту

my-app/
- package.json (Конфіг Node.js)
- server.js (Express сервер)
- Dockerfile (Docker конфіг)
- .gitignore (Git конфіг)
- public/
  - index.html (HTML сторінка)
  - style.css (Стилі)
  - script.js (JavaScript)

Технології

Backend: Node.js, Express
Frontend: HTML5, CSS3, Vanilla JavaScript
Deployment: Render.com або Railway.app

Розгортання на Render.com

1. Перейти на https://render.com
2. Натиснути "New Web Service"
3. Вибрати GitHub репозиторій
4. Натиснути "Deploy"

Розгортання на Railway.app

1. Перейти на https://railway.app
2. Натиснути "Start new project"
3. Вибрати "Deploy from GitHub repo"
4. Вибрати цей репозиторій
5. Натиснути "Deploy"

Автор

Гаврилов О.В. - AI243

