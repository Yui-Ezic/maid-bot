<?php

namespace App\Platform\Event\Struct;

class Message
{
    public function __construct(
        private User $user,
        private Chat $chat,
        private string $text,
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getText(): string
    {
        return $this->text;
    }
}