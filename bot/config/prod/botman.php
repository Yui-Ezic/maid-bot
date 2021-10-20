<?php

declare(strict_types=1);

use BotMan\Drivers\VK\VkCommunityCallbackDriver;

return [
    'config' => [
        'botman' => [
            'drivers' => [
                VkCommunityCallbackDriver::class
            ],
            'config' => [
                "vk" => [
                    // User or community token for sending messages (from Access tokens tab, see above)
                    "token" => env('VK_ACCESS_TOKEN', ''),

                    // Secret phrase for validating the request sender (from Callback API tab, see above)
                    "secret" => env('VK_SECRET_KEY', ''),

                    // API version to be used for sending an receiving messages (should be 5.103 and higher)
                    // (not recommended to change)
                    "version" => env('VK_API_VERSION', "5.103"),

                    // VK API endpoint (don't change it if unnecessary)
                    "endpoint" => env('VK_MESSAGES_ENDPOINT', "https://api.vk.com/method/"),

                    // DEPRECATED SINCE v.1.4.2, LEAVE BLANK (EMPTY STRING) - see 'Mounting & confirming the bot' section.
                    // Confirmation phrase for VK
                    "confirm" => "",

                    // Community or group ID
                    "group_id" => env('VK_GROUP_ID', ''),

                    // Extra user fields (see https://vk.com/dev/fields for custom fields) (leave blank for no extra fields)
                    // (note: screen_name is already included!)
                    "user_fields" => env('VK_USER_FIELDS', '')
                ]
            ]
        ]
    ],
];