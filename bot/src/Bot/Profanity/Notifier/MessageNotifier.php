<?php

declare(strict_types=1);

namespace App\Bot\Profanity\Notifier;

use App\Platform\Interactor\MessageSender;
use App\Profanity\Notifier\Notification;
use App\Profanity\Notifier\Notifier;

class MessageNotifier implements Notifier
{
    /**
     * @param string[] $recipientChatIds
     */
    public function __construct(
        private array $recipientChatIds,
        private MessageSender $messageSender,
        private MessageMaker $messageMaker
    ) {
    }

    public function notify(Notification $notification): void
    {
        $this->initMessageMaker($notification);
        $this->sendMessageToRecipients();
    }

    private function initMessageMaker(Notification $notification): void
    {
        $this->messageMaker->setNotification($notification);
    }

    private function sendMessageToRecipients(): void
    {
        $message = $this->messageMaker->make();
        foreach ($this->recipientChatIds as $chatId) {
            $this->messageSender->send($chatId, $message);
        }
    }
}
