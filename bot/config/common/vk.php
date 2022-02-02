<?php

declare(strict_types=1);

use App\Vk\Callback\CallbackHandler;
use App\Vk\Callback\ConfirmationCallbackHandler;
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
         * @psaml-var array{
         *   vk:array{
         *     handlers:array<string,CallbackHandler>
         *   },
         *   secret: string
         * } $config
         */
        $config = $container->get('config');

        /**
         * @psalm-suppress MissingClosureReturnType
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         */
        $handlers = array_map(static fn (string $name) => $container->get($name), $config['vk']['handlers']);

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
         * @psaml-var array{api:array{confirmationCode:string}, groupId:string} $config
         */
        $config = $container->get('config');

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         */
        return new ConfirmationCallbackHandler($config['vk']['api']['confirmationCode'], $config['vk']['groupId']);
    },
    VKApiClient::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @psaml-var array{api:array{version:string}} $config
         */
        $config = $container->get('config');

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         */
        return new VKApiClient($config['vk']['api']['version']);
    },
    ApiMessageSender::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @psaml-var array{api:array{accessToken:string}} $config
         */
        $config = $container->get('config');

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         */
        return new ApiMessageSender($container->get(VKApiClient::class), $config['vk']['api']['accessToken']);
    },
];
