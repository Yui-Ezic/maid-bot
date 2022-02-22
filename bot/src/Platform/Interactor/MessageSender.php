<?php

declare(strict_types=1);

namespace App\Platform\Interactor;

interface MessageSender
{
    public function send(string $chatId, Message $message): void;
}
