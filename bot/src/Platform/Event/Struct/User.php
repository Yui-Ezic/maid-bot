<?php

namespace App\Platform\Event\Struct;

class User
{
    public function __construct(
        private int $id
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}