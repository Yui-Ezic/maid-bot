<?php

declare(strict_types=1);

namespace App\Utils\Arrays;

use JsonSchema\Exception\InvalidArgumentException;

class Convertor
{
    public static function arrayToObjectRecursive($array): object
    {
        $json = json_encode($array);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = 'Unable to encode schema array as JSON';
            if (\function_exists('json_last_error_msg')) {
                $message .= ': ' . json_last_error_msg();
            }
            throw new InvalidArgumentException($message);
        }

        return (object)json_decode($json);
    }
}
