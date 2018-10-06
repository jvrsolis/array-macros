<?php

use Illuminate\Support\Arr;

/**
 * Add an element to an array using "dot" notation if it doesn't exist.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 * @return array
 */
Arr::macro('add', function ($array, $key, $value) {
    if (is_null(Arr::get($array, $key))) {
        Arr::set($array, $key, $value);
    }

    return $array;
});
