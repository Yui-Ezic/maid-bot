<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

class ArrayDictionary implements Dictionary
{
    public function __construct(
        /** @var string[] */
        private array $words
    ) {
        $this->words = $this->toLowerCase($this->words);
    }

    public function has(string $word): bool
    {
        $word = $this->toLowerCase($word);
        return \in_array($word, $this->words, true);
    }

    /**
     * @param string|string[] $value
     * @return string|string[]
     */
    private function toLowerCase(array|string $value): array|string
    {
        return \is_string($value) ?
            mb_strtolower($value) :
            array_map(static fn (string $word) => mb_strtolower($word), $value);
    }
}
