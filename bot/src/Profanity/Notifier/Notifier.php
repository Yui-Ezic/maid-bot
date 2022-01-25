<?php

declare(strict_types=1);

namespace App\Profanity\Notifier;

interface Notifier
{
    public function notify(Notification $notification): void;
}
