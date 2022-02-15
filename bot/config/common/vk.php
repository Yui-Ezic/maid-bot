<?php

declare(strict_types=1);

use App\Platform\Interactor\MessageSender;
use App\Vk\Callback\CallbackHandler;
use App\Vk\Callback\ConfirmationCallbackHandler;
use App\Vk\Callback\NewMessageCallbackHandler;
use App\Vk\Callback\UnionCallbackHandler;
use App\Vk\Interactor\ApiMessageSender;
use Psr\Container\ContainerInterface;
use VK\Client\VKApiClient;
use function App\env;

return [
    'config' => [
        'vk' => [
            'secret' => env('VK_SECRET'),
            'groupId' => (int)env('VK_GROUP_ID'),
            'handlers' => [
                'confirmation' => ConfirmationCallbackHandler::class,
                'new_message' => NewMessageCallbackHandler::class,
            ],
            'api' => [
                'version' => '5.131',
                'confirmationCode' => env('VK_CONFIRMATION_CODE'),
                'accessToken' => env('VK_ACCESS_TOKEN'),
            ],
        ],
    ],
    CallbackHandler::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @var array{
         *     vk:array{
         *         handlers:array<string,string>,
         *         secret:string
         *     },
         * } $config
         */
        $config = $container->get('config');

        $handlers = array_map(static function (string $name) use ($container): CallbackHandler {
            /** @var CallbackHandler */
            return $container->get($name);
        }, $config['vk']['handlers']);

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         * @psalm-suppress MixedArgumentTypeCoercion
         */
        return new UnionCallbackHandler($config['vk']['secret'], $handlers);
    },
    ConfirmationCallbackHandler::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @var array{
         *     vk:array{
         *         api:array{confirmationCode:string},
         *         groupId:int
         *     }
         * } $config
         */
        $config = $container->get('config');

        return new ConfirmationCallbackHandler($config['vk']['api']['confirmationCode'], $config['vk']['groupId']);
    },
    ApiMessageSender::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @var array{vk:array{api:array{accessToken:string}}} $config
         */
        $config = $container->get('config');

        return new ApiMessageSender($container->get(VKApiClient::class), $config['vk']['api']['accessToken']);
    },
    MessageSender::class => static fn (ContainerInterface $container): MessageSender => $container->get(ApiMessageSender::class),
];
