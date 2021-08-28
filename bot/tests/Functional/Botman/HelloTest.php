<?php

declare(strict_types=1);

namespace Test\Functional\Botman;

class HelloTest extends TestCase
{
    public function testHello()
    {
        $this->bot()
            ->receives('hello')
            ->assertReply('Hello yourself.');
    }
}