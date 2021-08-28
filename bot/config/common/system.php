<?php

declare(strict_types=1);

use function App\env;

return [
    'config' => [
        'debug' => (bool)env("APP_DEBUG", '0'),
    ]
];