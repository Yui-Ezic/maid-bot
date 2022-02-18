<?php

declare(strict_types=1);

namespace Test\Functional;

/**
 * @internal
 */
final class WebTestCaseTest extends WebTestCase
{
    public function testAppReturnSameObjectOnConsecutiveCalls(): void
    {
        self::assertSame($this->app(), $this->app());
    }

    public function testVkReturnSameObjectsOnConsecutiveCalls(): void
    {
        self::assertSame($this->vk(), $this->vk());
    }
}
