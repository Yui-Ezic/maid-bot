<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use App\Vk\Callback\Exception\InvalidCallbackSchema;
use DomainException;

class UnionCallbackHandler implements CallbackHandler
{
    public function __construct(
        private string $secret,
        /** @psalm-var array<string,CallbackHandler> [type => handler] */
        private array $handlers
    ) {
    }

    public function handle(object $callback): ?string
    {
        $this->validate($callback);
        $this->checkSecret($callback);
        return $this->runHandler($callback);
    }

    private function validate(object $callback): void
    {
        if (!isset($callback->type)) {
            throw new InvalidCallbackSchema('No type property.');
        }
        if (!\is_string($callback->type)) {
            throw new InvalidCallbackSchema('type is not string.');
        }
        if (!isset($callback->secret)) {
            throw new InvalidCallbackSchema('No secret property.');
        }
        if (!\is_string($callback->secret)) {
            throw new InvalidCallbackSchema('secret is not string.');
        }
    }

    private function checkSecret(object $callback): void
    {
        if ($callback->secret !== $this->secret) {
            throw new DomainException('Invalid secret.');
        }
    }

    private function runHandler(object $callback): ?string
    {
        if (isset($this->handlers[(string)$callback->type])) {
            return $this->handlers[(string)$callback->type]->handle($callback);
        }
        return null;
    }
}
