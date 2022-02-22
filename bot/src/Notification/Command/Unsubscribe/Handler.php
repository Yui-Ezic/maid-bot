<?php

declare(strict_types=1);

namespace App\Notification\Command\Unsubscribe;

use App\Notification\Repository\SubscriptionRepository;
use DomainException;

class Handler
{
    public function __construct(
        private SubscriptionRepository $repository
    ) {
    }

    public function handle(Command $command): void
    {
        if ($this->repository->has($command->subscriberId, $command->eventType)) {
            $this->repository->remove($command->subscriberId, $command->eventType);
        } else {
            throw new DomainException('Subscription does not exist.');
        }
    }
}
