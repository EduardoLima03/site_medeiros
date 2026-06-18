<?php

use App\Models\SiteSetting;

if (!function_exists('setting')) {
    function setting(string $key, string $default = ''): string
    {
        return SiteSetting::where('key', $key)->value('value') ?? $default;
    }
}
