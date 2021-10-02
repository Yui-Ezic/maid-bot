<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Detector\Dictionary;

use App\Profanity\Detector\Dictionary\StringSplitter;
use PHPUnit\Framework\TestCase;

class StringSplitterTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            ['', []],
            ['hello', ['hello']],
            ['hello!', ['hello']],
            ['hello)))', ['hello']],
            ['!be careful!', ['be', 'careful']],
            ['Hello, world!', ['Hello', 'world']],
            ['n1ce', ['n', 'ce']]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test($string, $expectedWords)
    {
        $splitter = new StringSplitter();

        $words = $splitter->splitToWords($string);

        self::assertEquals($expectedWords, $words);
    }
}