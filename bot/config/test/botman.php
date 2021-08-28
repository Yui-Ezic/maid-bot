<?php

declare(strict_types=1);

use BotMan\BotMan\Drivers\Tests\ProxyDriver;

return [
    'config' => [
        'botman' => [
            'drivers' => [
                ProxyDriver::class
            ],
            'config' => [
            ]
        ]
    ],
];