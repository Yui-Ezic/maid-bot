<?php

declare(strict_types=1);

namespace App\Profanity\Test\Unit;

use App\Profanity\Detector\Message;
use App\Profanity\Detector\Profanity;
use App\Profanity\Detector\ProfanityCollection;
use App\Profanity\Notifier\Notification;

class NotificationBuilder
{
    private const MESSAGE = 'message';
    private const PROFANITIES = 'profanities';

    private function __construct(private array $properties)
    {
    }

    public function build(): Notification
    {
        return new Notification($this->properties[self::MESSAGE], $this->properties[self::PROFANITIES]);
    }

    public static function random(): self
    {
        return new self([
            self::MESSAGE => new Message(uniqid()),
            self::PROFANITIES => self::getRandomProfanities(),
        ]);
    }

    private static function getRandomMessage(): Message
    {
        return new Message(uniqid());
    }

    private static function getRandomProfanities(): ProfanityCollection
    {
        $randomRange = range(1, random_int(1, 3));
        $profanitiesArray = array_map(static fn () => new Profanity(uniqid()), $randomRange);
        return new ProfanityCollection($profanitiesArray);
    }

    private function with(string $property, mixed $value): self
    {
        $clone = clone $this;
        $clone->properties[$property] = $value;
        return $clone;
    }
}
