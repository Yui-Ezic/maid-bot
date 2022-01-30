<?php

declare(strict_types=1);

namespace App\Platform\Test\Builder\Event\Struct;

use App\Platform\Event\Struct\User;
use RuntimeException;

class UserBuilder
{
    private const ID = 'id';

    private function __construct(
        /** @psalm-var array{id:int|null} */
        protected array $properties
    ) {
    }

    public function build(): User
    {
        if ($this->properties[self::ID] === null) {
            throw new RuntimeException('Id is empty.');
        }
        return new User($this->properties[self::ID]);
    }

    public static function random(): self
    {
        return new self([
            self::ID => random_int(0, getrandmax()),
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
