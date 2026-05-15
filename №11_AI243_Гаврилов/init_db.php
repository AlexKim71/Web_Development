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

