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
     * @param mixed $words
     * @param mixed $needle
     * @param mixed $expected
     */
    public function test($words, $needle, $expected): void
    {
        $dictionary = new ArrayDictionary($words);

        $result = $dictionary->has($needle);

        self::assertEquals($expected, $result);
    }
}
