<?php

use Illuminate\Support\Arr;

/**
 * Fill in missing numeric keys
 *
 * @return array
 */
Arr::macro('fillIn', function ($array, $default = null, $atleast = 0) {
    $array = $array + array_fill(0, max($atleast, max(array_keys($array))), $default);

    ksort($array);

    return $array;
});