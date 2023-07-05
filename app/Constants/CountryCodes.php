<?php

namespace App\Constants;

class CountryCodes
{
    static function getList()
    {
        if (file_exists(storage_path('CountryCodes.json'))) {
            $file = file_get_contents(storage_path('CountryCodes.json'));
            return json_decode($file, true);
        }
        return [];
    }
}
