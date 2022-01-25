<?php

declare(strict_types=1);

namespace App\Bot\Test\Unity\Profanity;

use App\Bot\Profanity\Notifier\MessageMaker;
use App\Bot\Profanity\Notifier\MessageNotifier;
use App\Platform\Interactor\MessageSender;
use App\Platform\Test\Unit\Interactor\MessageBuilder;
use App\Profanity\Test\Unit\NotificationBuilder;
use Exception;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class MessageNotifierTest extends TestCase
{
    /**
     * @var string[]
     */
    private array $recipientChatIds = [];

    /**
     * @psalm-var MockObject&MessageSender
     */
    private ?MockObject $messageSenderMock;

    /**
     * @psalm-var  MockObject&MessageMaker
     */
    private ?MockObject $messageMakerMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->recipientChatIds = [];
        $this->messageSenderMock = null;
        $this->messageMakerMock = null;
    }

    public function testInitMessageSender(): void
    {
        $notification = NotificationBuilder::random()->build();

        $this->getMessageMakerMock()
            ->expects(self::once())
            ->method('setNotification')
            ->with(self::equalTo($notification));

        $this->makeMessageNotifier()->notify($notification);
    }

    public function testMakeMessageWithChatId(): void
    {
        $this->addRecipients($recipients = $this->getRandomRecipients());
        $messageMakerMocks = $this->getMessageMakerMocks($recipients);

        // expects withChatId will be called for each recipient
        $this->getMessageMakerMock()
            ->expects(self::exactly(\count($this->recipientChatIds)))
            ->method('withChatId')
            ->withConsecutive(...$this->consecutiveEqualTo($recipients))
            ->willReturnOnConsecutiveCalls(...$messageMakerMocks);

        // expects 'make' be called once for all mock returned from 'withChatId'
        foreach ($messageMakerMocks as $messageMakerMock) {
            $messageMakerMock
                ->expects(self::once())
                ->method('make')
                ->willReturn(MessageBuilder::random()->build());
        }

        $this->makeMessageNotifier()->notify(NotificationBuilder::random()->build());
    }

    private function makeMessageNotifier(): MessageNotifier
    {
        return new MessageNotifier($this->recipientChatIds, $this->getMessageSenderMock(), $this->getMessageMakerMock());
    }

    /**
     * @psalm-return MockObject&MessageSender
     */
    private function getMessageSenderMock(): MockObject
    {
        if ($this->messageSenderMock === null) {
            $this->messageSenderMock = $this->createMock(MessageSender::class);
        }
        return $this->messageSenderMock;
    }

    /**
     * @psalm-return MockObject&MessageMaker
     */
    private function getMessageMakerMock(): MockObject
    {
        if ($this->messageMakerMock === null) {
            $this->messageMakerMock = $this->createMock(MessageMaker::class);
        }
        return $this->messageMakerMock;
    }

    /**
     * @param string[] $chatIds
     */
    private function addRecipients(array $chatIds): void
    {
        $this->recipientChatIds = array_merge($this->recipientChatIds, $chatIds);
    }

    /**
     * @throws Exception
     * @return string[]
     */
    private function getRandomRecipients(): array
    {
        $randomRange = range(1, random_int(1, 3));
        return array_map(static fn (int $value) => uniqid((string)$value), $randomRange);
    }

    /**
     * @param string[] $recipients
     * @return MockObject[]
     */
    private function getMessageMakerMocks(array $recipients): array
    {
        $messageMakerMocks = [];
        foreach ($recipients as $recipient) {
            $mock = $this->createMock(MessageMaker::class);
            $messageMakerMocks[$recipient] = $mock;
        }
        return $messageMakerMocks;
    }

    /**
     * @psalm-return array<array{0:Constraint}>
     */
    private function consecutiveEqualTo(array $values): array
    {
        return array_map(static fn (mixed $value) => [self::equalTo($value)], $values);
    }
}
