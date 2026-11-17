<?php

declare(strict_types=1);

function mbReverse(string $text): string
{
    $length = mb_strlen($text);
    $result = '';

    for ($i = $length - 1; $i >= 0; $i--) {
        $result .= mb_substr($text, $i, 1);
    }

    return $result;
}

function shortenLongWords(string $text, int $threshold = 7, int $keep = 6): string
{
    return (string)preg_replace_callback('/\p{L}+/u', static function (array $matches) use ($threshold, $keep): string {
        $word = $matches[0];

        if (mb_strlen($word) > $threshold) {
            return mb_substr($word, 0, $keep) . '*';
        }

        return $word;
    }, $text);
}

function analyzeText(string $text): array
{
    preg_match_all('/\p{L}+/u', $text, $wordMatches);
    $words = $wordMatches[0];

    $wordCount = count($words);
    $wordLengthSum = 0;

    foreach ($words as $word) {
        $wordLengthSum += mb_strlen($word);
    }

    $averageWordLength = $wordCount > 0 ? $wordLengthSum / $wordCount : 0.0;

    $sentencesRaw = preg_split('/[.!?]+/u', $text);
    $sentences = [];

    foreach ($sentencesRaw as $sentence) {
        $sentence = trim($sentence);
        if ($sentence !== '') {
            $sentences[] = $sentence;
        }
    }

    $sentenceCount = count($sentences);
    $totalWordsInSentences = 0;

    foreach ($sentences as $sentence) {
        preg_match_all('/\p{L}+/u', $sentence, $sentenceWords);
        $totalWordsInSentences += count($sentenceWords[0]);
    }

    $averageSentenceLength = $sentenceCount > 0 ? $totalWordsInSentences / $sentenceCount : 0.0;

    return [
        'word_count' => $wordCount,
        'sentence_count' => $sentenceCount,
        'average_word_length' => $averageWordLength,
        'average_sentence_length' => $averageSentenceLength,
    ];
}

function reverseWordsAndLetters(string $text): string
{
    $trimmed = trim($text);

    if ($trimmed === '') {
        return '';
    }

    $tokens = preg_split('/\s+/u', $trimmed);
    if ($tokens === false) {
        return '';
    }

    $tokens = array_reverse($tokens);

    foreach ($tokens as &$token) {
        $token = mbReverse($token);
    }

    unset($token);

    return implode(' ', $tokens);
}

