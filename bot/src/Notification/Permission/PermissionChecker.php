<?php

declare(strict_types=1);

namespace App\Notification\Permission;

use App\Notification\Struct\Subscription;

interface PermissionChecker
{
    public function isAllowed(Subscription $subscription): bool;
}