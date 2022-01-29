<?php

declare(strict_types=1);

namespace App\Platform\Event\Struct;

class Chat
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
