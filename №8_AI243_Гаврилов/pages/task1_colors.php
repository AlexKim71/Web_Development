<?php

declare(strict_types=1);

$pageTitle = 'Завдання 1: HTML-кольори';
$colors = [
    ['White', '#FFFFFF'],
    ['Silver', '#C0C0C0'],
    ['Gray', '#808080'],
    ['Black', '#000000'],
    ['Red', '#FF0000'],
    ['Maroon', '#800000'],
    ['Yellow', '#FFFF00'],
    ['Olive', '#808000'],
    ['Lime', '#00FF00'],
    ['Green', '#008000'],
    ['Aqua', '#00FFFF'],
    ['Teal', '#008080'],
    ['Blue', '#0000FF'],
    ['Navy', '#000080'],
    ['Fuchsia', '#FF00FF'],
    ['Purple', '#800080'],
    ['Orange', '#FFA500'],
    ['Pink', '#FFC0CB'],
    ['Brown', '#A52A2A'],
    ['Gold', '#FFD700'],
];

ob_start();
?>
<h1>Таблиця можливих кольорів HTML</h1>
<table class="table">
    <thead>
    <tr>
        <th>Назва</th>
        <th>HEX</th>
        <th>Приклад</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($colors as [$name, $hex]): ?>
        <tr>
            <td><?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
            <td><code><?= htmlspecialchars($hex, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></code></td>
            <td style="background: <?= htmlspecialchars($hex, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>;">&nbsp;</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$pageContent = (string)ob_get_clean();

