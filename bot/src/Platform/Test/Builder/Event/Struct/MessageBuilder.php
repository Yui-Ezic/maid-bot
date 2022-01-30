<?php

declare(strict_types=1);

namespace App\Platform\Test\Builder\Event\Struct;

use App\Platform\Event\Struct\Chat;
use App\Platform\Event\Struct\Message;
use App\Platform\Event\Struct\User;
use RuntimeException;

class MessageBuilder
{
    private const USER = 'user';
    private const CHAT = 'chat';
    private const TEXT = 'text';

    private function __construct(
        /** @psalm-var array{user:User|null, chat:Chat|null, text:string|null} */
        private array $properties
    ) {
    }

    public function build(): Message
    {
        if ($this->properties[self::USER] === null ||
            $this->properties[self::CHAT] === null ||
            $this->properties[self::TEXT] === null) {
            throw new RuntimeException('Chat, user or text is empty.');
        }
        return new Message($this->properties[self::USER], $this->properties[self::CHAT], $this->properties[self::TEXT]);
    }

    public function withText(string $value): self
    {
        return $this->with(self::TEXT, $value);
    }

    public static function random(): self
    {
        return new self([
            self::USER => UserBuilder::random()->build(),
            self::CHAT => ChatBuilder::random()->build(),
            self::TEXT => uniqid(),
        ]);
    }

    protected function with(string $property, mixed $value): static
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
