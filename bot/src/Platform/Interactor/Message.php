<?php

declare(strict_types=1);

namespace App\Platform\Interactor;

class Message
{
    public function __construct(
        private string $text
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
