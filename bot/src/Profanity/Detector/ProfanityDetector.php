<?php

declare(strict_types=1);

namespace App\Profanity\Detector;

interface ProfanityDetector
{
    public function detect(Message $message): ProfanityCollection;
}