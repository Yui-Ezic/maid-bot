<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use App\Vk\Callback\Exception\InvalidCallbackSchema;
use stdClass;

abstract class AbstractHandler
{
    protected function validate(stdClass $callback): void
    {
        if (!isset($callback->object)) {
            throw new InvalidCallbackSchema('No object property.');
        }
    }
}
