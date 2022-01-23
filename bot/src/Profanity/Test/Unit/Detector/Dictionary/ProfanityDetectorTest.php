<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Detector\Dictionary;

use App\Profanity\Detector\Dictionary\Dictionary;
use App\Profanity\Detector\Dictionary\ProfanityDetector;
use App\Profanity\Detector\Dictionary\StringSplitter;
use App\Profanity\Detector\Message;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ProfanityDetectorTest extends TestCase
{
    private Dictionary|MockObject $dictionary;
    private StringSplitter|MockObject $stringSplitter;
    private ProfanityDetector $profanityDetector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dictionary = $this->createMock(Dictionary::class);
        $this->stringSplitter = $this->createMock(StringSplitter::class);
        $this->profanityDetector = new ProfanityDetector($this->dictionary, $this->stringSplitter);
    }

    public function testCallSplitter(): void
    {
        $this->stringSplitter
            ->expects(self::once())
            ->method('splitToWords')
            ->withConsecutive([self::equalTo($string = uniqid())])
            ->willReturn([]);

        $this->profanityDetector->detect(new Message($string));
    }

    public function testCheckAllSplittedWord(): void
    {
        $this->stringSplitter
            ->method('splitToWords')
            ->willReturn($words = ['a', 'b', 'c']);

        $this->dictionary
            ->expects(self::exactly(\count($words)))
            ->method('has')
            ->withConsecutive(
                [self::equalTo('a')],
                [self::equalTo('b')],
                [self::equalTo('c')],
            )
            ->willReturn(false);

        $this->profanityDetector->detect(new Message('test'));
    }
}
