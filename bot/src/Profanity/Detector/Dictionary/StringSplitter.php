<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

class StringSplitter
{
    public function splitToWords(string $string): array
    {
        return preg_split('/\PL+/u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
}
