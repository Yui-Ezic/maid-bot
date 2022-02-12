<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use App\Vk\Callback\Exception\InvalidCallbackSchema;

abstract class AbstractHandler implements CallbackHandler
{
    protected function validate(array $callback): void
    {
        if (!isset($callback['object'])) {
            throw new InvalidCallbackSchema('No object property.');
        }
        if (!\is_array($callback['object'])) {
            throw new InvalidCallbackSchema('object property is not object.');
        }
    }
}
