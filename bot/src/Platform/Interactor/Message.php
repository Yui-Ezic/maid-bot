<?php

declare(strict_types=1);

namespace App\Platform\Interactor;

use JsonSerializable;

class Message implements JsonSerializable
{
    public function __construct(
        private string $text
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function jsonSerialize(): array
    {
        return [
            'text' => $this->getText(),
        ];
    }
}
