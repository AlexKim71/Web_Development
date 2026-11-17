<?php

declare(strict_types=1);

require_once __DIR__ . '/../lib/text_tasks.php';

function assertSame(string $expected, string $actual, string $message): void
{
    if ($expected !== $actual) {
        fwrite(STDERR, "[FAIL] {$message}\nExpected: {$expected}\nActual:   {$actual}\n");
        exit(1);
    }

    echo "[OK] {$message}\n";
}

$task3Input = 'Я купив бронетранспортер учора';
$task3Expected = 'Я купив бронет* учора';
assertSame($task3Expected, shortenLongWords($task3Input), 'Task 3 shortening');

$task4Input = 'Мого собаку звуть Мухтар. Вона знає багато команд.';
$task4Expected = '.днамок отагаб єанз аноВ .ратхуМ ьтузв укабос огоМ';
assertSame($task4Expected, reverseWordsAndLetters($task4Input), 'Task 4 reverse words and letters');

$analysis = analyzeText($task4Input);
if ((int)$analysis['word_count'] !== 8 || (int)$analysis['sentence_count'] !== 2) {
    fwrite(STDERR, "[FAIL] Task 4 analysis counts\n");
    exit(1);
}

echo "[OK] Task 4 analysis counts\n";
echo "All smoke tests passed.\n";

