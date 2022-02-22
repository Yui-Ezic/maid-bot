<?php

declare(strict_types=1);

namespace App\Notification\Subscription\Struct;

class Subscription
{
    public function __construct(
        private string $subscriberId,
        private string $eventType,
    ) {
    }

    public function getSubscriberId(): string
    {
        return $this->subscriberId;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }
}
