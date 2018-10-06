<?php

use Illuminate\Support\Arr;

/**
 * Get a value from the array, and remove it.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
Arr::macro('pull', function (&$array, $key, $default = null) {
    $value = Arr::get($array, $key, $default);

    Arr::forget($array, $key);

    return $value;
});