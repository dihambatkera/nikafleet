<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get or set settings key-value pair.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}
