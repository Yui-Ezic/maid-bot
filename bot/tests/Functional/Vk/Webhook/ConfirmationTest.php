<?php

declare(strict_types=1);

namespace Test\Functional\Vk\Webhook;

use Test\Functional\WebTestCase;

/**
 * @internal
 */
final class ConfirmationTest extends WebTestCase
{
    private const CORRECT_VK_SECRET = 'vk_secret';
    private const WRONG_VK_SECRET = 'wrong_vk_secret';
    private const CORRECT_GROUP_ID = 1;
    private const WRONG_GROUP_ID = 10;
    private const CONFIRMATION_TYPE = 'confirmation';

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/vk/webhook', [
            'type' => self::CONFIRMATION_TYPE,
            'group_id' => self::CORRECT_GROUP_ID,
            'secret' => self::CORRECT_VK_SECRET,
        ]));

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('vk_confirmation_code', (string)$response->getBody());
    }

    public function testWrongSecret(): void
    {
        $response = $this->app()->handle(self::json('POST', '/vk/webhook', [
            'type' => self::CONFIRMATION_TYPE,
            'group_id' => self::CORRECT_GROUP_ID,
            'secret' => self::WRONG_VK_SECRET,
        ]));

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Ok', (string)$response->getBody());
    }

    public function testWrongGroupId(): void
    {
        $response = $this->app()->handle(self::json('POST', '/vk/webhook', [
            'type' => self::CONFIRMATION_TYPE,
            'group_id' => self::WRONG_GROUP_ID,
            'secret' => self::CORRECT_VK_SECRET,
        ]));

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Ok', (string)$response->getBody());
    }
}
