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

