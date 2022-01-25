<?php

declare(strict_types=1);

namespace App\Platform\Test\Unit\Interactor;

use App\Platform\Interactor\Message;
use RuntimeException;

class MessageBuilder
{
    private const CHAT_ID = 'chatId';
    private const TEXT = 'text';

    private function __construct(
        /** @psalm-var array{chatId:string|null, text:string|null} */
        private array $properties
    ) {
    }

    public function build(): Message
    {
        if ($this->properties[self::CHAT_ID] === null || $this->properties[self::TEXT] === null) {
            throw new RuntimeException('ChatId or text is empty.');
        }
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
        /**
         * @psalm-suppress InvalidPropertyAssignmentValue
         * @psalm-suppress PropertyTypeCoercion
         */
        $clone->properties[$property] = $value;
        return $clone;
    }
}
