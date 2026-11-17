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

