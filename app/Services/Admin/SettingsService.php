<?php

namespace App\Services\Admin;

class SettingsService
{
    public function save(array $params): void
    {
        foreach ($params as $key => $value) {
            setting([$key => $value]);
        }
        setting()->save();
    }
}
