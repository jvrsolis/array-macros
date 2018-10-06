<?php

use Illuminate\Support\Arr;

/**
 * Determines if an array is associative.
 *
 * An array is "associative" if it doesn't have sequential numerical keys
 * beginning with zero.
 *
 * @param  array  $array
 * @return bool
 */
Arr::macro('isAssoc', function ($array) {
    $keys = array_keys($array);

    return array_keys($keys) !== $keys;
});