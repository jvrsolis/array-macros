<?php

use Illuminate\Support\Arr;

/**
 * Expands a dotted associative array. The inverse of Arr::dot().
 *
 * @param  array $array
 * @return array
 */
Arr::macro('to', function ($key, $mixed) {
    $array = Arr::get($key);
    if (is_array($array)) {
        Arr::set($key, array_push($array, $mixed));
    } else {
        Arr::set($key, $mixed);
    }
});