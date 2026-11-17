<?php

declare(strict_types=1);

$pageTitle = 'Завдання 2: Результат гри';
$state = gameGetState();

ob_start();
?>
<h1>Результат гри</h1>

<?php if ((bool)$state['is_over']): ?>
    <div class="notice">
        <strong><?= htmlspecialchars((string)$state['winner'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong>
    </div>
    <p>Фінальні HP: гравець <?= (int)$state['player_hp'] ?>, сервер <?= (int)$state['server_hp'] ?>.</p>
<?php else: ?>
    <div class="error">Гра ще не завершена.</div>
<?php endif; ?>

<p><a href="index.php?module=games&page=game1">Повернутися до гри</a></p>

<form action="actions/game_reset.php" method="post">
    <button type="submit">Почати заново</button>
</form>
<?php
$pageContent = (string)ob_get_clean();

