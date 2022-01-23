<?php

declare(strict_types=1);

namespace App\Platform\Test\Unit\Interactor;

use App\Platform\Interactor\Message;

class MessageBuilder
{
    private const CHAT_ID = 'chatId';
    private const TEXT = 'text';

    private function __construct(private array $properties)
    {
    }

    public function build(): Message
    {
        return new Message($this->properties[self::CHAT_ID], $this->properties[self::TEXT]);
    }

    public static function random(): self
    {
        return new self([
            self::CHAT_ID => uniqid(),
            self::TEXT => uniqid(),
        ]);
    }

    private function with(string $property, mixed $value): self
    {
        $clone = clone $this;
        $clone->properties[$property] = $value;
        return $clone;
    }
}
