<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

class ArrayDictionary implements Dictionary
{
    public function __construct(
        /** @var string[] */
        private array $words
    )
    {}

    public function has(string $word): bool
    {
        return in_array($word, $this->words);
    }
}