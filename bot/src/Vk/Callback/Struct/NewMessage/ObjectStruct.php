<?php

declare(strict_types=1);

namespace App\Vk\Callback\Struct\NewMessage;

class ObjectStruct
{
    public function __construct(private Message $message)
    {
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
