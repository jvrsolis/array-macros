<?php

use Illuminate\Support\Arr;

/**
 * Concatenate values of a given key as a string.
 *
 * @param  string  $value
 * @param  string  $glue
 * @return string
 */
Arr::macro('implodeWithKeys', function ($array, $value, $glue = null) {
    $first = Arr::first($array);

    if (is_array($first) || is_object($first)) {
        return implode($glue, Arr::pluck($array, $value));
    }

    return implode($value, $array);
});