<?php

use Illuminate\Support\Arr;

/**
 * Slice the array having associative keys.
 *
 * @param  int  $offset
 * @param  int  $length
 * @return static
 */
Arr::macro('sliceAssoc', function (array $array, array $keys) {
    return array_intersect_key($array, array_flip($keys));
});