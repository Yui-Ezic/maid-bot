<?php

declare(strict_types=1);

namespace Test\Functional\Botman;

class NoReplyTest extends TestCase
{
    public function testNoReply()
    {
        $this->bot()
            ->receives('Message without matching.')
            ->assertReply(null);
    }
}