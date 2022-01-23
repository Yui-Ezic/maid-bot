<?php

declare(strict_types=1);

namespace App\Profanity\Detector\Dictionary;

use App\Profanity\Detector\Message;
use App\Profanity\Detector\Profanity;
use App\Profanity\Detector\ProfanityCollection;
use App\Profanity\Detector\ProfanityDetector as ProfanityDetectorInterface;

class ProfanityDetector implements ProfanityDetectorInterface
{
    public function __construct(
        private Dictionary $dictionary,
        private StringSplitter $stringSplitter
    ) {
    }

    public function detect(Message $message): ProfanityCollection
    {
        $words = $this->stringSplitter->splitToWords($message->text);
        $profanityArray = $this->findProfanities($words);
        return new ProfanityCollection($profanityArray);
    }

    /**
     * @param string[] $words
     * @return Profanity[]
     */
    private function findProfanities(array $words): array
    {
        $profanities = array_filter($words, fn (string $word) => $this->dictionary->has($word));

        return array_map(static fn (string $profanity) => new Profanity($profanity), $profanities);
    }
}
