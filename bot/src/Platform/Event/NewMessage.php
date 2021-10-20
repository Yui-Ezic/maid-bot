<?php

namespace App\Platform\Event;

use App\Platform\Event\Struct\Message;

class NewMessage
{
    public function __construct(
        private Message $message
    )
    {
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}