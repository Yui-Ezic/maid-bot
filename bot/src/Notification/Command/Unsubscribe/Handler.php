<?php

declare(strict_types=1);

namespace App\Notification\Command\Unsubscribe;

use App\Notification\Subscription\Repository\SubscriptionRepository;
use DomainException;

class Handler
{
    public function __construct(
        private SubscriptionRepository $repository
    ) {
    }

    public function handle(Command $command): void
    {
        if ($this->repository->has($command->subscriptionId)) {
            $this->repository->remove($command->subscriptionId);
        } else {
            throw new DomainException('Subscription does not exist.');
        }
    }
}
