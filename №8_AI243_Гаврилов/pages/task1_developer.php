<?php

declare(strict_types=1);

$pageTitle = 'Завдання 1: Інформація про розробника';
$developerFile = __DIR__ . '/../data/developer.txt';
$sourceLabel = 'data/developer.txt';

if (is_file($developerFile)) {
    $developerContent = (string)file_get_contents($developerFile);
} else {
    $developerContent = 'Файл data/developer.txt не знайдено.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['developer_file']) && is_uploaded_file($_FILES['developer_file']['tmp_name'])) {
    $uploaded = (string)file_get_contents($_FILES['developer_file']['tmp_name']);
    if ($uploaded !== '') {
        $developerContent = $uploaded;
        $sourceLabel = 'завантажений файл: ' . (string)($_FILES['developer_file']['name'] ?? 'невідомо');
    }
}

ob_start();
?>
<h1>Інформація про розробника</h1>
<p class="small">Скрипт читає і відображає файл з інформацією про розробника.</p>

<form method="post" enctype="multipart/form-data">
    <label for="developer_file">Завантажте TXT-файл (необов'язково):</label>
    <input type="file" id="developer_file" name="developer_file" accept=".txt,text/plain">
    <br><br>
    <button type="submit">Завантажити і показати</button>
</form>

<p class="small">Джерело: <code><?= htmlspecialchars($sourceLabel, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></code></p>
<pre class="card"><?= htmlspecialchars($developerContent, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></pre>
<?php
$pageContent = (string)ob_get_clean();


