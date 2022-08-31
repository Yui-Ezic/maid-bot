<?php

declare(strict_types=1);

namespace App\Notification\Subscription\Repository;

use App\Notification\Subscription\Struct\Subscription;

interface SubscriptionRepository
{
    public function persist(Subscription $subscription): void;

    public function has(string $id): bool;

    /**
     * @return Subscription[]
     */
    public function findByEventId(string $id): array;

    public function remove(string $id): void;
}
