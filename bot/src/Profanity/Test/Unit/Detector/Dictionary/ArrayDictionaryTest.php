<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Detector\Dictionary;

use App\Profanity\Detector\Dictionary\ArrayDictionary;
use PHPUnit\Framework\TestCase;

class ArrayDictionaryTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [[$word = uniqid()], $word, true],
            [['word'], 'another', false],
            [['HeLLo'], 'hello', true],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test($words, $needle, $expected)
    {
        $dictionary = new ArrayDictionary($words);

        $result = $dictionary->has($needle);

        self::assertEquals($expected, $result);
    }
}