<?php

declare(strict_types=1);

namespace App\Bot\Hello;

use App\Platform\Event\NewMessage;
use App\Platform\Interactor\Message;
use App\Platform\Interactor\MessageSender;

class NewMessageHandler
{
    public function __construct(private MessageSender $messageSender)
    {
    }

    public function handle(NewMessage $message): void
    {
        $messageText = $message->getMessage()->getText();
        if (mb_strtolower($messageText) === 'hello') {
            $chatId = $message->getMessage()->getChat()->getId();
            $this->messageSender->send(new Message($chatId, 'world'));
        }
    }
}
