<?php

declare(strict_types=1);

const GAME_SESSION_KEY = 'game1';
const GAME_BASE_HP = 10;

function gameInit(): void
{
    if (!isset($_SESSION[GAME_SESSION_KEY])) {
        $_SESSION[GAME_SESSION_KEY] = [
            'player_hp' => GAME_BASE_HP,
            'server_hp' => GAME_BASE_HP,
            'is_over' => false,
            'winner' => null,
            'log' => [],
        ];
    }
}

function gameGetState(): array
{
    gameInit();
    return $_SESSION[GAME_SESSION_KEY];
}

function gameReset(): void
{
    unset($_SESSION[GAME_SESSION_KEY]);
    gameInit();
}

function gamePlayRound(int $playerWeapon): void
{
    gameInit();

    if ($_SESSION[GAME_SESSION_KEY]['is_over']) {
        return;
    }

    $playerWeapon = max(1, min(3, $playerWeapon));
    $serverWeapon = rand(1, 3);
    $damage = rand(1, 4);

    if ($playerWeapon === $serverWeapon) {
        $_SESSION[GAME_SESSION_KEY]['player_hp'] -= $damage;
    } else {
        $_SESSION[GAME_SESSION_KEY]['server_hp'] -= $damage;
    }

    $playerHp = $_SESSION[GAME_SESSION_KEY]['player_hp'];
    $serverHp = $_SESSION[GAME_SESSION_KEY]['server_hp'];

    if ($playerWeapon === $serverWeapon) {
        $_SESSION[GAME_SESSION_KEY]['log'][] = sprintf(
            'Збіг вибору (%d). Система завдала %d шкоди гравцю. HP: гравець=%d, система=%d.',
            $serverWeapon,
            $damage,
            $playerHp,
            $serverHp
        );
    } else {
        $_SESSION[GAME_SESSION_KEY]['log'][] = sprintf(
            'Гравець=%d, система=%d. Гравець завдав %d шкоди системі. HP: гравець=%d, система=%d.',
            $playerWeapon,
            $serverWeapon,
            $damage,
            $playerHp,
            $serverHp
        );
    }

    if ($playerHp <= 0 || $serverHp <= 0) {
        $_SESSION[GAME_SESSION_KEY]['is_over'] = true;

        if ($playerHp <= 0 && $serverHp <= 0) {
            $_SESSION[GAME_SESSION_KEY]['winner'] = 'Нічия';
        } elseif ($playerHp <= 0) {
            $_SESSION[GAME_SESSION_KEY]['winner'] = 'Перемогла система';
        } else {
            $_SESSION[GAME_SESSION_KEY]['winner'] = 'Переміг гравець';
        }
    }
}


