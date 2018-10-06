<?php

use Illuminate\Support\Arr;

/**
 * Get the keys of the array items.
 *
 * @return static
 */
Arr::macro('keys', function (array $array) {
    return array_keys($array);
});