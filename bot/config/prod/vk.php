<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use VK\Client\VKApiClient;

return [
    VKApiClient::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedAssignment
         * @var array{vk:array{api:array{version:string}}} $config
         */
        $config = $container->get('config');

        return new VKApiClient($config['vk']['api']['version']);
    },
];
