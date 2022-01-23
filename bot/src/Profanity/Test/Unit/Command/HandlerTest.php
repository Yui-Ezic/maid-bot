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
    private Handler $handler;
    private ProfanityDetector|MockObject $profanityDetectorMock;
    private Notifier|MockObject $notifierMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->profanityDetectorMock = $this->createMock(ProfanityDetector::class);
        $this->notifierMock = $this->createMock(Notifier::class);
        $this->handler = new Handler($this->profanityDetectorMock, $this->notifierMock);
    }

    public function testNotifyIfProfanityDetected(): void
    {
        $command = new Command('message');
        $this->profanityDetectorMock
            ->method('detect')
            ->willReturn($profanities = new ProfanityCollection([new Profanity('test')]));

        $this->notifierMock
            ->expects(self::once())
            ->method('notify')
            ->with(self::callback(static function (Notification $value) use ($command, $profanities) {
                return
                    $value->getMessage()->text === $command->text &&
                    $value->getProfanities() === $profanities;
            }));

        $this->handler->handle($command);
    }

    public function testNotNotifyIfProfanityNotDetected(): void
    {
        $command = new Command('message');
        $this->profanityDetectorMock
            ->method('detect')
            ->willReturn(new ProfanityCollection([]));

        $this->notifierMock
            ->expects(self::never())
            ->method('notify');

        $this->handler->handle($command);
    }
}
