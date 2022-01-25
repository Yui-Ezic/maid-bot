<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit\Command;

use App\Profanity\Command\CheckMessage\Command;
use App\Profanity\Command\CheckMessage\Handler;
use App\Profanity\Detector\Profanity;
use App\Profanity\Detector\ProfanityCollection;
use App\Profanity\Detector\ProfanityDetector;
use App\Profanity\Notifier\Notification;
use App\Profanity\Notifier\Notifier;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HandlerTest extends TestCase
{
    /**
     * @psalm-var MockObject&ProfanityDetector|null
     */
    private ?MockObject $profanityDetectorMock;

    /**
     * @psalm-var MockObject&Notifier|null
     */
    private ?MockObject $notifierMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->profanityDetectorMock = null;
        $this->notifierMock = null;
    }

    public function testNotifyIfProfanityDetected(): void
    {
        $command = new Command('message');
        $this->getProfanityDetectorMock()
            ->method('detect')
            ->willReturn($profanities = new ProfanityCollection([new Profanity('test')]));

        $this->getNotifierMock()
            ->expects(self::once())
            ->method('notify')
            ->with(self::callback(static function (Notification $value) use ($command, $profanities) {
                return
                    $value->getMessage()->text === $command->text &&
                    $value->getProfanities() === $profanities;
            }));

        $this->getHandler()->handle($command);
    }

    public function testNotNotifyIfProfanityNotDetected(): void
    {
        $command = new Command('message');
        $this->getProfanityDetectorMock()
            ->method('detect')
            ->willReturn(new ProfanityCollection([]));

        $this->getNotifierMock()
            ->expects(self::never())
            ->method('notify');

        $this->getHandler()->handle($command);
    }

    private function getHandler(): Handler
    {
        return new Handler($this->getProfanityDetectorMock(), $this->getNotifierMock());
    }

    /**
     * @psalm-return MockObject&ProfanityDetector
     */
    private function getProfanityDetectorMock(): MockObject
    {
        if ($this->profanityDetectorMock === null) {
            $this->profanityDetectorMock = $this->createMock(ProfanityDetector::class);
        }
        return $this->profanityDetectorMock;
    }

    /**
     * @psalm-return MockObject&Notifier
     */
    private function getNotifierMock(): MockObject
    {
        if ($this->notifierMock === null) {
            $this->notifierMock = $this->createMock(Notifier::class);
        }
        return $this->notifierMock;
    }
}
