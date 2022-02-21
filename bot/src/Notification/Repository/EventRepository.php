<?php

declare(strict_types=1);

namespace App\Notification\Repository;

interface EventRepository
{
    public function has(string $eventType);
}
