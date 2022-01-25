<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

class ArrayDictionary implements Dictionary
{
    public function __construct(
        /** @var string[] */
        private array $words
    ) {
        $this->words = $this->StringListToLowerCase($words);
    }

    public function has(string $word): bool
    {
        $word = $this->stringToLowerCase($word);
        return \in_array($word, $this->words, true);
    }

    private function stringToLowerCase(string $value): string
    {
        return mb_strtolower($value);
    }

    /**
     * @param string[] $value
     * @return string[]
     */
    private function StringListToLowerCase(array $value): array
    {
        return array_map(static fn (string $word) => mb_strtolower($word), $value);
    }
}
