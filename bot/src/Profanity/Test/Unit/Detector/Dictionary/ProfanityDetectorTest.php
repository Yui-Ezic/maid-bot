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
    /**
     * @psalm-var MockObject&Dictionary|null
     */
    private ?MockObject $dictionaryMock;

    /**
     * @psalm-var MockObject&StringSplitter|null
     */
    private ?MockObject $stringSplitterMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dictionaryMock = null;
        $this->stringSplitterMock = null;
    }

    public function testCallSplitter(): void
    {
        $this->getStringSplitterMock()
            ->expects(self::once())
            ->method('splitToWords')
            ->withConsecutive([self::equalTo($string = uniqid())])
            ->willReturn([]);

        $this->getProfanityDetector()->detect(new Message($string));
    }

    public function testCheckAllSplittedWord(): void
    {
        $this->getStringSplitterMock()
            ->method('splitToWords')
            ->willReturn($words = ['a', 'b', 'c']);

        $this->getDictionaryMock()
            ->expects(self::exactly(\count($words)))
            ->method('has')
            ->withConsecutive(
                [self::equalTo('a')],
                [self::equalTo('b')],
                [self::equalTo('c')],
            )
            ->willReturn(false);

        $this->getProfanityDetector()->detect(new Message('test'));
    }

    private function getProfanityDetector(): ProfanityDetector
    {
        return new ProfanityDetector($this->getDictionaryMock(), $this->getStringSplitterMock());
    }

    /**
     * @psalm-return MockObject&Dictionary
     */
    private function getDictionaryMock(): MockObject
    {
        if ($this->dictionaryMock === null) {
            $this->dictionaryMock = $this->createMock(Dictionary::class);
        }
        return $this->dictionaryMock;
    }

    /**
     * @psalm-return MockObject&StringSplitter
     */
    private function getStringSplitterMock(): MockObject
    {
        if ($this->stringSplitterMock === null) {
            $this->stringSplitterMock = $this->createMock(StringSplitter::class);
        }
        return $this->stringSplitterMock;
    }
}
