<?php

declare(strict_types=1);

namespace App\Bot\Hello\Listener;

use App\Platform\Event\NewMessage;
use App\Platform\Interactor\Message;
use App\Platform\Interactor\MessageSender;

class NewMessageListener
{
    public function __construct(private MessageSender $messageSender)
    {
    }

    public function __invoke(NewMessage $message): void
    {
        $messageText = $message->getMessage()->getText();
        if (mb_strtolower($messageText) === 'hello') {
            $chatId = $message->getMessage()->getChat()->getId();
            $this->messageSender->send($chatId, new Message('world'));
        }
    }
}
