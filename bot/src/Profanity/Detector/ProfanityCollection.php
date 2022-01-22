<?php

declare(strict_types=1);

namespace App\Profanity\Detector;

use ArrayIterator;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use Stringable;

class ProfanityCollection implements IteratorAggregate, Stringable
{
    public function __construct(
        /**
         * @var Profanity[]
         */
        private array $profanities = []
    )
    {
        foreach ($this->profanities as $profanity) {
            if (!$profanity instanceof Profanity) {
                throw new InvalidArgumentException('Profanities should be instance of ' . Profanity::class);
            }
        }
    }

    public function notEmpty(): bool
    {
        return !empty($this->profanities);
    }

    /**
     * @return Iterator<Profanity>
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->profanities);
    }

    public function __toString()
    {
        return implode(', ', $this->profanities);
    }
}