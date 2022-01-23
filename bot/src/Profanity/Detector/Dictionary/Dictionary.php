<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

interface Dictionary
{
    public function has(string $word): bool;
}
