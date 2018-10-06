<?php

use Illuminate\Support\Arr;

/**
 * Reverse keys of an array.
 *
 * @return array
 */
Arr::macro('reverseKeys', function ($array) {
    return array_reverse(array_reverse($array, true), false);
});