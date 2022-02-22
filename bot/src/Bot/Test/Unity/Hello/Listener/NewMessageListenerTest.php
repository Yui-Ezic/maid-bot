<?php

declare(strict_types=1);

namespace App\Bot\Test\Unity\Hello\Listener;

use App\Bot\Hello\Listener\NewMessageListener;
use App\Platform\Event\NewMessage;
use App\Platform\Interactor\Message;
use App\Platform\Interactor\MessageSender;
use App\Platform\Test\Builder\Event\Struct\MessageBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class NewMessageListenerTest extends TestCase
{
    /**
     * @psalm-var MockObject&MessageSender|null
     */
    private ?MockObject $messageSenderMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageSenderMock = null;
    }

    public function testReplyOnHello(): void
    {
        $event = new NewMessage(MessageBuilder::random()->withText('hello')->build());

        $this->getMessageSenderMock()
            ->expects(self::once())
            ->method('send')
            ->with($event->getMessage()->getChat()->getId(), new Message('world'));

        $this->dispatchEvent($event);
    }

    public function testDontReplyOnRandomString(): void
    {
        $event = new NewMessage(MessageBuilder::random()->withText(uniqid('rand'))->build());

        $this->getMessageSenderMock()
            ->expects(self::never())
            ->method('send');

        $this->dispatchEvent($event);
    }

    private function dispatchEvent(NewMessage $event): void
    {
        $this->getNewMessageListener()($event);
    }

    private function getNewMessageListener(): NewMessageListener
    {
        return new NewMessageListener($this->getMessageSenderMock());
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
}
