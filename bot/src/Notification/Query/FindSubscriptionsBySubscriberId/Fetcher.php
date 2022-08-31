<?php

declare(strict_types=1);

namespace App\Notification\Query\FindSubscriptionsBySubscriberId;

interface Fetcher
{
    /**
     * @return Subscription[]
     */
    public function fetch(Query $query): array;
}