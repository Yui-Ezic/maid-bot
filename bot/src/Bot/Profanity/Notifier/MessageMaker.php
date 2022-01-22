<?php

namespace App\Bot\Profanity\Notifier;

use App\Platform\Interactor\Message;
use App\Profanity\Notifier\Notification;

class MessageMaker
{
    private const CHAT_ID = 'chatId';
    private const TEXT = 'text';

    public function __construct(private array $properties)
    {
    }

    public function make(): Message
    {
        return new Message($this->properties[self::CHAT_ID], self::TEXT);
    }

    public function setNotification(Notification $notification): self
    {
        $text = $this->makeMessageTextByNotification($notification);
        $this->properties[self::TEXT] = $text;
        return $this;
    }

    public function withChatId(string $value): self
    {
        return $this->with(self::CHAT_ID, $value);
    }

    private function makeMessageTextByNotification(Notification $notification): string
    {
        return "{$notification->getMessage()} Profanities list: " . $notification->getProfanities();
    }

    private function with(string $property, mixed $value): self
    {
        $clone = clone $this;
        $clone->properties[$property] = $value;
        return $clone;
    }
}