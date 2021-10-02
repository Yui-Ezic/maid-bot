<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

class StringSplitter
{
    public function splitToWords(string $string): array
    {
        return preg_split('/\s+/', $string);
    }
}