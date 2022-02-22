<?php

declare(strict_types=1);

namespace App\Notification\Repository;

use App\Notification\Struct\Subscription;

interface SubscriptionRepository
{
    public function persist(Subscription $subscription): void;

    public function has(string $subscriberId, string $eventType): bool;

    public function remove(string $subscriberId, string $eventType): void;
}
