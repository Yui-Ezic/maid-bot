<?php

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
    )
    {
    }

    public function notify(Notification $notification)
    {
        $this->initMessageMaker($notification);
        $this->sendMessagesToRecipients();
    }

    private function initMessageMaker(Notification $notification)
    {
        $this->messageMaker->setNotification($notification);
    }

    private function sendMessagesToRecipients()
    {
        array_walk($this->recipientChatIds, function (string $chatId) {
            $message = $this->messageMaker->withChatId($chatId)->make();
            $this->messageSender->send($message);
        });
    }
}