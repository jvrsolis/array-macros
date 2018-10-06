<?php

use Illuminate\Support\Arr;

/**
 * Concatenate values of an array.
 *
 * @param  string  $value
 * @param  string  $glue
 * @return string
 */
Arr::macro('implode', function ($array, $glue = '') {
    return implode($glue, $array);
});