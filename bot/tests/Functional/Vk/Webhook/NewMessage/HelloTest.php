<?php

declare(strict_types=1);

namespace Test\Functional\Vk\Webhook\NewMessage;

use Test\Functional\WebTestCase;
use Test\Mock\Expectation\CallbackExpectation;
use Test\Mock\Expectation\InvokeMethodExpectation;

/**
 * @internal
 */
final class HelloTest extends WebTestCase
{
    private const CORRECT_VK_SECRET = 'vk_secret';
    private const CORRECT_GROUP_ID = 1;
    private const CORRECT_ACCESS_TOKEN = 'vk_access_token';
    private const MESSAGE_NEW_TYPE = 'message_new';

    public function testResponseOnHello(): void
    {
        $request = self::json('POST', '/vk/webhook', [
            'type' => self::MESSAGE_NEW_TYPE,
            'group_id' => self::CORRECT_GROUP_ID,
            'secret' => self::CORRECT_VK_SECRET,
            'object' => [
                'message' => [
                    'peer_id' => $peerId = random_int(0, getrandmax()),
                    'from_id' => random_int(0, getrandmax()),
                    'text' => 'hello',
                ],
            ],
        ]);

        $this->vk()
            ->getRequest()
            ->expect(new InvokeMethodExpectation('post', 1))
            ->expect(new CallbackExpectation(
                'post',
                1,
                static function (array $arguments) use ($peerId) {
                    /** @var array{method:string, access_token:string, params:array{peer_id:int,message:string}} $arguments */
                    $params = $arguments['params'];
                    return $arguments['method'] === 'messages.send' &&
                    $arguments['access_token'] === self::CORRECT_ACCESS_TOKEN &&
                    $params['peer_id'] === $peerId &&
                    $params['message'] === 'world';
                }
            ));

        $response = $this->app()->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Ok', (string)$response->getBody());
        $this->vk()->getRequest()->assertExpectations();
    }
}
