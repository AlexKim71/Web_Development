# Структура файлів проекту my-app

Повна структура директорій та код кожного файлу проекту лабораторної роботи №13 (AI243).

---

Файл package.json

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\package.json

Опис: Файл конфігурації Node.js проекту. Містить інформацію про проект, скрипти запуску та залежності.

Код:
```json
{
  "name": "my-app",
  "version": "1.0.0",
  "description": "Simple web application",
  "main": "server.js",
  "scripts": {
    "start": "node server.js",
    "dev": "node server.js"
  },
  "keywords": [],
  "author": "",
  "license": "ISC",
  "dependencies": {
    "express": "^4.18.2"
  }
}
```



Файл server.js

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\server.js

Опис: Головний файл Express сервера. Запускає веб-додаток на порту 3000 (або змінній оточення PORT).

Код:
```javascript
const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Подаём статические файлы из папки public
app.use(express.static(path.join(__dirname, 'public')));

// Главный маршрут
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// API маршрут (пример)
app.get('/api/hello', (req, res) => {
  res.json({ message: 'Hello from Node.js Express!' });
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
```



Файл Dockerfile

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\Dockerfile

Опис: Файл для створення Docker образу. Містить інструкції щодо збірки контейнера з Node.js додатком.

Код:
```dockerfile
# Простой Dockerfile для Node.js
FROM node:18

WORKDIR /app

COPY . .

RUN npm install

EXPOSE 3000

CMD ["npm", "start"]
```



Файл .gitignore

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\.gitignore

Опис: Файл конфігурації Git. Вказує, які папки та файли ігнорувати при завантаженні на GitHub.

Код:
```
node_modules/
.env
.DS_Store
*.log
```



Файл .dockerignore

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\.dockerignore

Опис: Файл конфігурації Docker. Вказує, які файли не копіювати в Docker образ.

Код:
```
node_modules
npm-debug.log
.git
.gitignore
.idea
```



Файл public/index.html

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\public\index.html

Опис: Головна HTML сторінка сайту. Структура та вміст веб-інтерфейсу.

Код:
```html
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web App - AI243</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🚀 Hello World!</h1>
            <p>Лабораторна робота №13 - AI243 - Гаврилов О.В.</p>
        </header>

        <main>
            <section class="card">
                <h2>Ласкаво просимо!</h2>
                <p>Це простий веб-додаток, розгорнутий на безкоштовному сервері.</p>
            </section>

            <section class="card">
                <h3>Технологічний стек:</h3>
                <ul>
                    <li>Node.js + Express</li>
                    <li>HTML/CSS/JavaScript</li>
                    <li>Развернуто на Render/Railway</li>
                </ul>
            </section>

            <section class="card">
                <button id="fetchBtn" class="btn">Натисніть мене →</button>
                <p id="response"></p>
            </section>
        </main>

        <footer>
            <p>&copy; 2026 My App | <a href="https://github.com" target="_blank">GitHub</a></p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>
```



Файл public/style.css

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\public\style.css

Опис: CSS стилі для оформлення веб-сторінки. Містить градієнти, адаптивний дизайн, анімації.

Код:
```css
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    max-width: 600px;
    width: 100%;
    padding: 40px;
}

header {
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 3px solid #667eea;
    padding-bottom: 20px;
}

header h1 {
    color: #333;
    font-size: 2.5em;
    margin-bottom: 10px;
}

header p {
    color: #666;
    font-size: 0.95em;
}

main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.card h2,
.card h3 {
    color: #333;
    margin-bottom: 10px;
}

.card p {
    color: #666;
    line-height: 1.6;
}

.card ul {
    list-style: none;
    padding-left: 0;
}

.card ul li {
    color: #666;
    padding: 8px 0;
    padding-left: 20px;
    position: relative;
}

.card ul li:before {
    content: "✓";
    color: #667eea;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    font-size: 1em;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn:active {
    transform: translateY(0);
}

#response {
    color: #667eea;
    font-weight: bold;
    margin-top: 15px;
}

footer {
    text-align: center;
    margin-top: 30px;
    border-top: 1px solid #eee;
    padding-top: 20px;
    color: #999;
    font-size: 0.9em;
}

footer a {
    color: #667eea;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

@media (max-width: 600px) {
    .container {
        padding: 20px;
    }

    header h1 {
        font-size: 1.8em;
    }
}
```



Файл public/script.js

Директорія: C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\public\script.js

Опис: JavaScript код для інтерактивності. Обробляє клацання на кнопці та виконує API запит.

Код:
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const fetchBtn = document.getElementById('fetchBtn');
    const response = document.getElementById('response');

    fetchBtn.addEventListener('click', async function() {
        try {
            const res = await fetch('/api/hello');
            const data = await res.json();
            response.textContent = `✅ ${data.message}`;
        } catch (error) {
            response.textContent = '❌ Помилка при завантаженні!';
            console.error('Error:', error);
        }
    });

    console.log('🎉 Додаток завантажений успішно!');
});
```



Підсумкова таблиця файлів

Список всіх файлів проекту:

1. package.json - Конфіг Node.js проекту
2. server.js - Express сервер (бекенд)
3. Dockerfile - Docker конфігурація
4. .gitignore - Git конфігурація
5. .dockerignore - Docker конфігурація
6. public/index.html - Головна сторінка (фронтенд)
7. public/style.css - Стилі сторінки
8. public/script.js - Інтерактивність

Повний шлях установки проекту

C:\Users\gavry\OneDrive\Desktop\№13_AI243_Гаврилов\
- package.json
- server.js
- Dockerfile
- .gitignore
- .dockerignore
- public/
  - index.html
  - style.css
  - script.js

Команди для запуску

Локально (Node.js):
npm install
npm start
Відкрийте http://localhost:3000

З Docker:
docker build -t my-app .
docker run -p 3000:3000 my-app
Відкрийте http://localhost:3000

Git команди:
git init
git add .
git commit -m "first deploy"
git branch -M main
git remote add origin https://github.com/ВАШ-НIК/my-app.git
git push -u origin main

Дата створення: 2026-05-27
Автор: Гаврилов О.В.
Група: AI243
Лабораторна робота: №13

