<?php

use Illuminate\Support\Arr;

/**
 * Sort a multidimensional array by keys and values.
 *
 * @param  array  $array
 * @return array
 */
Arr::macro('sortMulti', function (array $array) {
    foreach ($array as &$value) {
        if (is_array($value)) {
            $value = static::sortMulti($value);
        }
    }

    if (static::isAssoc($array)) {
        ksort($array);
    } else {
        sort($array);
    }

    return $array;
});