<?php

namespace App\Bot\Test\Unity\Profanity;

use App\Bot\Profanity\Notifier\MessageMaker;
use App\Bot\Profanity\Notifier\MessageNotifier;
use App\Platform\Interactor\Message;
use App\Platform\Interactor\MessageSender;
use App\Profanity\Test\Unit\NotificationBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MessageNotifierTest extends TestCase
{
    private array $recipientChatIds = [];
    private MessageSender|MockObject $messageSenderMock;
    private MessageMaker|MockObject $messageMakerMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageSenderMock = $this->createMock(MessageSender::class);
        $this->messageMakerMock = $this->createMock(MessageMaker::class);
    }

    public function testInitMessageSender()
    {
        $notification = NotificationBuilder::random()->build();

        $this->messageMakerMock
            ->expects($this->once())
            ->method('setNotification')
            ->with($this->equalTo($notification));

        $this->makeMessageNotifier()->notify($notification);
    }

    private function makeMessageNotifier(): MessageNotifier
    {
        return new MessageNotifier($this->recipientChatIds, $this->messageSenderMock, $this->messageMakerMock);
    }

    private function addRecipients(array $chatIds)
    {
        $this->recipientChatIds = array_merge($this->recipientChatIds, $chatIds);
    }
}