<?php

declare(strict_types=1);

$pageTitle = 'Завдання 1: Таблиця множення';

ob_start();
?>
<h1>Таблиця множення (1-10)</h1>
<table class="table">
    <thead>
    <tr>
        <th>x</th>
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <th><?= $i ?></th>
        <?php endfor; ?>
    </tr>
    </thead>
    <tbody>
    <?php for ($row = 1; $row <= 10; $row++): ?>
        <tr>
            <th><?= $row ?></th>
            <?php for ($col = 1; $col <= 10; $col++): ?>
                <td><?= $row * $col ?></td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
    </tbody>
</table>
<?php
$pageContent = (string)ob_get_clean();

