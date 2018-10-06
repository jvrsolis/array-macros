<?php

use Illuminate\Support\Arr;

/**
 * Explode the "value" and "key" arguments passed to "pluck".
 *
 * @param  string|array  $value
 * @param  string|array|null  $key
 * @return array
 */
Arr::macro('explodePluckParameters', function ($value, $key) {
    $value = is_string($value) ? explode('.', $value) : $value;

    $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

    return [$value, $key];
});