<?php

declare(strict_types=1);

namespace App\Vk\Callback;

interface CallbackHandler
{
    public function handle(object $callback): ?string;
}
