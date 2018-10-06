<?php

use Illuminate\Support\Arr;

/**
 * Slice the array.
 *
 * @param  int  $offset
 * @param  int  $length
 * @return static
 */
Arr::macro('slice', function ($array, int $offset, int $length = null) {
    return array_slice($array, $offset, $length, true);
});