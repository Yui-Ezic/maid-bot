<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Detector\Dictionary;

use App\Profanity\Detector\Dictionary\Dictionary;
use App\Profanity\Detector\Dictionary\ProfanityDetector;
use App\Profanity\Detector\Dictionary\StringSplitter;
use App\Profanity\Detector\Message;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProfanityDetectorTest extends TestCase
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

    public function testCallSplitter()
    {
        $this->stringSplitter
            ->expects($this->once())
            ->method('splitToWords')
            ->withConsecutive([$this->equalTo($string = uniqid())])
            ->willReturn([]);

        $this->profanityDetector->detect(new Message($string));
    }

    public function testCheckAllSplittedWord()
    {
        $this->stringSplitter
            ->method('splitToWords')
            ->willReturn($words = ['a', 'b', 'c']);

        $this->dictionary
            ->expects($this->exactly(count($words)))
            ->method('has')
            ->withConsecutive(
                [$this->equalTo('a')],
                [$this->equalTo('b')],
                [$this->equalTo('c')],
            )
            ->willReturn(false);

        $this->profanityDetector->detect(new Message('test'));
    }
}