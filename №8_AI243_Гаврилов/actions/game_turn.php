<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../lib/game.php';

$weapon = isset($_POST['weapon']) ? (int)$_POST['weapon'] : 1;

gamePlayRound($weapon);
$state = gameGetState();

if ((bool)$state['is_over']) {
    header('Location: ../index.php?module=games&page=game1over');
    exit;
}

header('Location: ../index.php?module=games&page=game1');
exit;

