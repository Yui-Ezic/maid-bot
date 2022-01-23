<?php

declare(strict_types=1);

namespace App\Platform\Interactor;

class Message
{
    public function __construct(
        private string $chatId,
        private string $text
    ) {
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
