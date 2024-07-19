<?php

namespace App\Models;

class SettingsHelper
{
    /**
     * @param string $key
     * @return string
     */
    public static function getSetting(string $key = ''): string
    {
        $setting = Settings::whereKeyCd(strtoupper($key))->where(['hide' => 1])->first();

        if ($setting) {
            return $setting->value;
        } else {
            return '';
        }
    }

    /**
     * @param string $key
     * @return int
     */
    public static function getId(string $key): int
    {
        $setting = Settings::whereKeyCd(strtoupper($key))->first();

        return $setting->id;
    }
}
