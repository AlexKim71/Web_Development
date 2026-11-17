<?php

declare(strict_types=1);

$pageTitle = 'Завдання 4: Аналіз текстового файлу';

$defaultFile = __DIR__ . '/../data/input_text.txt';
$defaultText = is_file($defaultFile) ? (string)file_get_contents($defaultFile) : '';

$sourceText = $defaultText;
$analysis = null;
$transformedText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sourceText = (string)($_POST['source_text'] ?? '');

    if (isset($_FILES['text_file']) && is_uploaded_file($_FILES['text_file']['tmp_name'])) {
        $uploadedText = (string)file_get_contents($_FILES['text_file']['tmp_name']);
        if ($uploadedText !== '') {
            $sourceText = $uploadedText;
        }
    }

    $analysis = analyzeText($sourceText);
    $transformedText = reverseWordsAndLetters($sourceText);
}

ob_start();
?>
<h1>Аналіз тексту з файлу</h1>
<p class="small">Обчислюється середня довжина слова (символи), середня довжина речення (слова), а також виконується реверс літер у словах і порядку слів.</p>

<form method="post" enctype="multipart/form-data">
    <label for="text_file">TXT-файл (необов'язково):</label>
    <input type="file" id="text_file" name="text_file" accept=".txt,text/plain">

    <br><br>

    <label for="source_text">Або вставте текст:</label>
    <textarea id="source_text" name="source_text"><?= htmlspecialchars($sourceText, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>

    <br>
    <button type="submit">Проаналізувати</button>
</form>

<?php if (is_array($analysis)): ?>
    <h2>Результат аналізу</h2>
    <div class="card">
        <p><strong>Кількість слів:</strong> <?= (int)$analysis['word_count'] ?></p>
        <p><strong>Кількість речень:</strong> <?= (int)$analysis['sentence_count'] ?></p>
        <p><strong>Середня довжина слова:</strong> <?= number_format((float)$analysis['average_word_length'], 3, ',', ' ') ?> символів</p>
        <p><strong>Середня довжина речення:</strong> <?= number_format((float)$analysis['average_sentence_length'], 3, ',', ' ') ?> слів</p>
    </div>

    <h2>Текст після реверсу</h2>
    <div class="card"><?= htmlspecialchars($transformedText, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
<?php endif; ?>
<?php
$pageContent = (string)ob_get_clean();

