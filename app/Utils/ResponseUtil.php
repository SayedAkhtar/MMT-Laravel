<?php

namespace App\Utils;

class ResponseUtil
{
    /**
     * @param  string  $success
     * @param  string  $message
     * @param  mixed  $data
     *
     * @return array
     */
    public static function generateResponse(string $success, string $message, $data): array
    {
        return [
            'STATUS'  => $success,
            'MESSAGE' => $message,
            'DATA'    => $data,
        ];
    }

    /**
     * @param  string  $error
     * @param  string  $message
     * @param  mixed  $data
     *
     * @return array
     */
    public static function generateError(string $error, string $message, $data): array
    {
        return [
            'STATUS'  => $error,
            'MESSAGE' => $message,
            'ERROR'   => $data,
        ];
    }
}
