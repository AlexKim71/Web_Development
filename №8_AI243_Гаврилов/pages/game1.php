<?php

declare(strict_types=1);

$pageTitle = 'Завдання 2: Міні-гра';
$state = gameGetState();

ob_start();
?>
<h1>Міні-гра: симулятор поєдинку</h1>
<p class="small">Зброя: числа 1, 2, 3. Якщо вибір гравця збігається з сервером - шкода йде гравцю, інакше - серверу.</p>

<div class="card">
    <p><strong>HP гравця:</strong> <?= (int)$state['player_hp'] ?></p>
    <p><strong>HP сервера:</strong> <?= (int)$state['server_hp'] ?></p>
</div>

<?php if (!(bool)$state['is_over']): ?>
    <form action="actions/game_turn.php" method="post">
        <label for="weapon">Оберіть зброю (1-3):</label>
        <input type="number" id="weapon" name="weapon" min="1" max="3" required>
        <br><br>
        <button type="submit">Зробити хід</button>
    </form>
<?php else: ?>
    <div class="notice">Гра завершена. Перейдіть на сторінку результату.</div>
    <p><a href="index.php?module=games&page=game1over">Перейти до результату</a></p>
<?php endif; ?>

<form action="actions/game_reset.php" method="post">
    <button type="submit" class="secondary">Почати заново</button>
</form>

<h2>Лог ходів</h2>
<div class="log">
    <?php if (empty($state['log'])): ?>
        <p>Поки що ходів немає.</p>
    <?php else: ?>
        <?php foreach (array_reverse($state['log']) as $entry): ?>
            <p><?= htmlspecialchars((string)$entry, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php
$pageContent = (string)ob_get_clean();

