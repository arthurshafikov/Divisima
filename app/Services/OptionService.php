<?php

namespace App\Services;

use App\Models\Option;

class OptionService
{
    protected static array $options = [];

    public static function getOption(string $option, $val = false)
    {
        if (!array_key_exists($option, static::$options)) {
            static::$options[$option] = optional(Option::firstWhere('key', $option))->value;
        }
        $option = static::$options[$option];

        if ($val === false) {
            return $option;
        }
        return data_get($option, $val);
    }
}
