<?php

declare(strict_types=1);

namespace App\Vk\Callback\Exception;

use DomainException;

class InvalidCallbackSchema extends DomainException
{
    public function __construct(string $description)
    {
        $message = "Wrong callback schema: {$description}";
        parent::__construct($message);
    }
}
