<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Test\Mock\Vk\VkApiClientMock;
use Test\Mock\Vk\VkApiRequestMock;
use VK\Client\VKApiClient;

return [
    VKApiClient::class => static function (ContainerInterface $container): VkApiClient {
        /**
         * @psalm-suppress MixedAssignment
         * @var array{vk:array{api:array{version:string}}} $config
         */
        $config = $container->get('config');

        $vkApiRequest = new VkApiRequestMock($config['vk']['api']['version']);

        return new VkApiClientMock($vkApiRequest);
    },
];
