<?php

declare(strict_types=1);

namespace App\Bot\Profanity\Notifier;

use App\Platform\Interactor\Message;
use App\Profanity\Notifier\Notification;

class MessageMaker
{
    private const TEXT = 'text';

    public function __construct(
        /**
         * @psalm-var array{text:string}
         */
        private array $properties
    ) {
    }

    public function make(): Message
    {
        return new Message($this->properties[self::TEXT]);
    }

    public function setNotification(Notification $notification): self
    {
        $text = $this->makeMessageTextByNotification($notification);
        $this->properties[self::TEXT] = $text;
        return $this;
    }

    private function makeMessageTextByNotification(Notification $notification): string
    {
        return "{$notification->getMessage()} Profanities list: " . $notification->getProfanities();
    }
}
