<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Detector\Dictionary;

use App\Profanity\Detector\Dictionary\StringSplitter;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class StringSplitterTest extends TestCase
{
    /**
     * @psalm-return array<array{0:string,1:array<string>}>
     */
    public function dataProvider(): array
    {
        return [
            ['', []],
            ['hello', ['hello']],
            ['hello!', ['hello']],
            ['hello)))', ['hello']],
            ['!be careful!', ['be', 'careful']],
            ['Hello, world!', ['Hello', 'world']],
            ['n1ce', ['n', 'ce']],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param string[] $expectedWords
     */
    public function test(string $string, array $expectedWords): void
    {
        $splitter = new StringSplitter();

        $words = $splitter->splitToWords($string);

        self::assertEquals($expectedWords, $words);
    }
}
