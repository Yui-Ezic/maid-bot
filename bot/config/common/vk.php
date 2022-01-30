<?php

declare(strict_types=1);

use App\Vk\Callback\CallbackHandler;
use App\Vk\Callback\ConfirmationCallbackHandler;
use App\Vk\Callback\UnionCallbackHandler;
use Psr\Container\ContainerInterface;
use function App\env;

return [
    'config' => [
        'vk' => [
            'secret' => env('VK_SECRET'),
            'groupId' => (int)env('VK_GROUP_ID'),
            'confirmationCode' => env('VK_CONFIRMATION_CODE'),
            'handlers' => [
                'confirmation' => ConfirmationCallbackHandler::class,
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
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         */
        return new UnionCallbackHandler($config['vk']['handlers'], $config['vk']['secret']);
    },
    ConfirmationCallbackHandler::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @psaml-var array{confirmationCode:string, groupId:string} $config
         */
        $config = $container->get('config');

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-suppress MixedArgument
         */
        return new ConfirmationCallbackHandler($config['vk']['confirmationCode'], $config['vk']['groupId']);
    },
];
