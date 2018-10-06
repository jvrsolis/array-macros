<?php

use Illuminate\Support\Arr;

/**
 * Reset the keys on the array.
 *
 * @return static
 */
Arr::macro('values', function (array $array) {
    return array_values($array);
});