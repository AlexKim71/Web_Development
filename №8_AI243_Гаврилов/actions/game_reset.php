<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../lib/game.php';

gameReset();

header('Location: ../index.php?module=games&page=game1');
exit;

