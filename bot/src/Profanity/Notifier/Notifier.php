<?php

declare(strict_types=1);

namespace App\Profanity\Notifier;

use App\Profanity\Detector\ProfanityCollection;

interface Notifier
{
    public function notify(Notification $notification);
}