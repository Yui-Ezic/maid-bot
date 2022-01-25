<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Detector\Dictionary;

use App\Profanity\Detector\Dictionary\ArrayDictionary;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ArrayDictionaryTest extends TestCase
{
    /**
     * @psalm-return array<array{0:array<string>,1:string,2:bool}>
     */
    public function dataProvider(): array
    {
        return [
            [[$word = uniqid()], $word, true],
            [['word'], 'another', false],
            [['HeLLo'], 'hello', true],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param string[] $words
     */
    public function test(array $words, string $needle, bool $expected): void
    {
        $dictionary = new ArrayDictionary($words);

        $result = $dictionary->has($needle);

        self::assertEquals($expected, $result);
    }
}
