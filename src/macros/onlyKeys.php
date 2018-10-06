<?php

use Illuminate\Support\Arr;

/**
 * Get a subset of the items from an array given the keys.
 *
 * @param  array  $array
 * @param  array|string  $keys
 * @return array
 */
Arr::macro('onlyKeys', function (array $array, $keys) {
    return array_intersect_key($array, array_flip((array)$keys));
});