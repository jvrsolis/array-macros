<?php

use Illuminate\Support\Arr;

/**
 * Push an item onto the beginning of an array.
 *
 * @param  array  $array
 * @param  mixed  $value
 * @param  mixed  $key
 * @return array
 */
Arr::macro('prepend', function ($array, $value, $key = null) {
    if (is_null($key)) {
        array_unshift($array, $value);
    } else {
        $array = [$key => $value] + $array;
    }

    return $array;
});