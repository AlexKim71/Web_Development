Путь в проекте: `db.php`
```php
<?php

declare(strict_types=1);

function getConnection(): PDO
{
    $databaseDir = __DIR__ . DIRECTORY_SEPARATOR . 'database';

    if (!is_dir($databaseDir)) {
        mkdir($databaseDir, 0777, true);
    }

    $databasePath = $databaseDir . DIRECTORY_SEPARATOR . 'lab11.sqlite';
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}
```

Путь в проекте: `init_db.php`
```php
<?php

declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'db.php';

$pdo = getConnection();

$pdo->exec('DROP TABLE IF EXISTS users');
$pdo->exec('CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE
)');

$insertStmt = $pdo->prepare('INSERT INTO users (full_name, email) VALUES (:full_name, :email)');

for ($i = 1; $i <= 53; $i++) {
    $insertStmt->execute([
        ':full_name' => "Користувач {$i}",
        ':email' => "user{$i}@example.com",
    ]);
}

echo "Базу даних створено: database/lab11.sqlite\n";
echo "Додано користувачів: 53\n";
```

Путь в проекте: `index.php`
```php
<?php

declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'db.php';

$pdo = getConnection();

$page = filter_input(
    INPUT_GET,
    'page',
    FILTER_VALIDATE_INT,
    ['options' => ['default' => 1, 'min_range' => 1]]
);

$limit = 10;
$offset = ($page - 1) * $limit;

$totalUsers = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalPages = max(1, (int) ceil($totalUsers / $limit));

if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

$usersStmt = $pdo->prepare('SELECT id, full_name, email FROM users ORDER BY id LIMIT :limit OFFSET :offset');
$usersStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$usersStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$usersStmt->execute();
$users = $usersStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторна 11 - Пагінація користувачів</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Лабораторна робота 11</h1>
    <p>Гаврилов О.В. AI243 | Варіант 8</p>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>ПІБ</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars((string) $user['id']) ?></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($totalUsers === 0): ?>
        <p>У таблиці поки немає користувачів. Запустіть <code>init_db.php</code>.</p>
    <?php else: ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Попередня</a>
            <?php else: ?>
                <span class="disabled">&laquo; Попередня</span>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <?php if ($p === $page): ?>
                    <span class="current"><?= $p ?></span>
                <?php else: ?>
                    <a href="?page=<?= $p ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">Наступна &raquo;</a>
            <?php else: ?>
                <span class="disabled">Наступна &raquo;</span>
            <?php endif; ?>
        </div>
        <p class="page-meta">Сторінка <?= $page ?> з <?= $totalPages ?> (усього користувачів: <?= $totalUsers ?>)</p>
    <?php endif; ?>
</div>
</body>
</html>
```

Путь в проекте: `style.css`
```css
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 24px;
    font-family: Arial, sans-serif;
    background: #f6f7fb;
    color: #1f2937;
}

.container {
    max-width: 860px;
    margin: 0 auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

h1 {
    margin-top: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
}

th,
td {
    border: 1px solid #d1d5db;
    padding: 10px;
    text-align: left;
}

th {
    background: #f3f4f6;
}

.pagination {
    margin-top: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.pagination a,
.pagination .disabled,
.pagination .current {
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    border: 1px solid #9ca3af;
}

.pagination a {
    color: #111827;
    background: #e5e7eb;
}

.pagination .disabled {
    color: #9ca3af;
    border-color: #d1d5db;
    background: #f9fafb;
}

.pagination .current {
    color: #ffffff;
    background: #2563eb;
    border-color: #2563eb;
    font-weight: 700;
}

.page-meta {
    margin-top: 8px;
    color: #4b5563;
}
```

Путь в проекте: `README.md`
````markdown
# Лабораторна робота №11

**Студент:** Гаврилов О.В. AI243  
**Варіант:** 8

## Завдання
Реалізувати пагінацію списку користувачів з використанням `LIMIT`, `OFFSET` і кнопок переходу між сторінками.

У проєкті реалізовано:
- `LIMIT 10` на сторінку.
- `OFFSET = (page - 1) * 10`.
- Кнопки `Попередня` / `Наступна`.
- Номерні кнопки сторінок `1..N`.

## Структура проєкту
```text
№11_AI243_Гаврилов/
├── index.php
├── init_db.php
├── db.php
├── style.css
├── README.md
└── database/
    └── lab11.sqlite
```

## Опис файлів
- `index.php` — головна сторінка з виведенням користувачів і пагінацією.
- `init_db.php` — створює таблицю `users` і тестові записи.
- `db.php` — підключення до SQLite через PDO.
- `style.css` — стилізація сторінки.
- `database/lab11.sqlite` — файл бази даних SQLite.

## Запуск (PowerShell)
```powershell
cd "$HOME\Desktop\№11_AI243_Гаврилов"
php init_db.php
php -S 127.0.0.1:8000
```

Відкрити у браузері:
- `http://127.0.0.1:8000/index.php`

## Перевірка пагінації
- `http://127.0.0.1:8000/index.php?page=1`
- `http://127.0.0.1:8000/index.php?page=2`
- `http://127.0.0.1:8000/index.php?page=6`
````

Путь в проекте: `database/lab11.sqlite`
Это бинарный файл SQLite, поэтому текст кода для него отсутствует.

