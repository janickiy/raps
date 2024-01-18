<?php

namespace App\Helpers;

use App\Models\Settings;

class SettingsHelper
{
    /**
     * @param string $key
     * @return string
     */
    public static function getSetting(string $key = '')
    {
        $setting = Settings::whereKeyCd(strtoupper($key))->first();

        if ($setting) {
            return $setting->value;
        } else {
            return '';
        }
    }
}
