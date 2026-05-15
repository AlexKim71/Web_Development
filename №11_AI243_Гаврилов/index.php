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

