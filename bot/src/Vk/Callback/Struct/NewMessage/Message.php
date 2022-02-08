<?php

declare(strict_types=1);

namespace App\Vk\Callback\Struct\NewMessage;

class Message
{
    public function __construct(
        private int $fromId,
        private int $peerId,
        private string $text,
    ) {
    }

    public function getFromId(): int
    {
        return $this->fromId;
    }

    public function getPeerId(): int
    {
        return $this->peerId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
