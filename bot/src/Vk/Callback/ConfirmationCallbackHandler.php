<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use App\Vk\Callback\Exception\InvalidCallbackSchema;

class ConfirmationCallbackHandler implements CallbackHandler
{
    public function __construct(private string $confirmationCode, private int $groupId)
    {
    }

    public function handle(object $callback): ?string
    {
        $this->validate($callback);
        if ($callback->group_id === $this->groupId) {
            return $this->confirmationCode;
        }
        return null;
    }

    private function validate(object $callback): void
    {
        if (!isset($callback->group_id)) {
            throw new InvalidCallbackSchema('No group_id property.');
        }
        if (!\is_int($callback->group_id)) {
            throw new InvalidCallbackSchema('group_id is not int.');
        }
    }
}
