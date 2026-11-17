<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/lib/game.php';
require_once __DIR__ . '/lib/text_tasks.php';

$page = $_GET['page'] ?? '';
$module = $_GET['module'] ?? '';

// Підтримка формату index.php?page=game1 з умови лабораторної.
if ($module === '' && $page === 'game1') {
    $module = 'games';
}
if ($module === '' && $page === 'game1over') {
    $module = 'games';
}

$pageTitle = 'ЛР8: Основи мови PHP';
$pageContent = '';

if ($module === '' && $page === '') {
    ob_start();
    ?>
    <h1>Лабораторна робота №8</h1>
    <p><strong>Тема:</strong> Основи мови PHP</p>
    <p><strong>Студент:</strong> Гаврилов О.В., AI-243</p>

    <div class="card">
        <h2>Завдання 1</h2>
        <ul>
            <li><a href="phpinfo.php" target="_blank" rel="noopener">Інформація про налаштування PHP (phpinfo)</a></li>
            <li><a href="index.php?module=task1&page=developer">Інформація про розробника з файлу</a></li>
            <li><a href="index.php?module=task1&page=colors">Таблиця можливих кольорів HTML</a></li>
            <li><a href="index.php?module=task1&page=multiplication">Таблиця множення</a></li>
        </ul>
    </div>

    <div class="card">
        <h2>Завдання 2</h2>
        <p><a href="index.php?module=games&page=game1">Міні-гра: симулятор поєдинку</a></p>
    </div>

    <div class="card">
        <h2>Завдання 3</h2>
        <p><a href="index.php?module=task3&page=shorten">Скорочення слів довше 7 символів</a></p>
    </div>

    <div class="card">
        <h2>Завдання 4</h2>
        <p><a href="index.php?module=task4&page=analyze">Аналіз текстового файлу та реверс тексту</a></p>
    </div>
    <?php
    $pageContent = (string)ob_get_clean();
} else {
    $routeMap = [
        'task1:developer' => __DIR__ . '/pages/task1_developer.php',
        'task1:colors' => __DIR__ . '/pages/task1_colors.php',
        'task1:multiplication' => __DIR__ . '/pages/task1_multiplication.php',
        'games:game1' => __DIR__ . '/pages/game1.php',
        'games:game1over' => __DIR__ . '/pages/game1over.php',
        'task3:shorten' => __DIR__ . '/pages/task3_shorten.php',
        'task4:analyze' => __DIR__ . '/pages/task4_analyze.php',
    ];

    $key = $module . ':' . $page;

    if (isset($routeMap[$key])) {
        require $routeMap[$key];
    } else {
        $pageTitle = 'Сторінку не знайдено';
        $pageContent = '<div class="error">Невірний маршрут. Поверніться на <a href="index.php">головну</a>.</div>';
    }
}
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <p class="small"><a href="index.php">На головну</a></p>
    <?= $pageContent ?>
</div>
</body>
</html>

