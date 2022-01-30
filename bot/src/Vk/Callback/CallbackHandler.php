<?php

declare(strict_types=1);

namespace App\Vk\Callback;

use stdClass;

interface CallbackHandler
{
    public function handle(stdClass $callback): ?string;
}
