<?php

declare(strict_types=1);

$pageTitle = 'Завдання 3: Скорочення довгих слів';

$input = $_POST['input_text'] ?? 'Я купив бронетранспортер учора';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = shortenLongWords((string)$input);
}

ob_start();
?>
<h1>Скорочення слів довше 7 символів</h1>
<p class="small">Правило: якщо слово містить більше 7 символів, залишаємо перші 6 і додаємо <code>*</code>.</p>

<form method="post">
    <label for="input_text">Вхідний текст:</label>
    <textarea id="input_text" name="input_text"><?= htmlspecialchars((string)$input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>
    <br>
    <button type="submit">Обробити</button>
</form>

<?php if ($result !== ''): ?>
    <h2>Результат</h2>
    <div class="card"><?= htmlspecialchars($result, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
<?php endif; ?>
<?php
$pageContent = (string)ob_get_clean();

