<?php

use Illuminate\Support\Arr;

/**
 * Get a subset of the items from an array given the values.
 *
 * @param  array  $array
 * @param  array|string  $keys
 * @return array
 */
Arr::macro('onlyValues', function (array $array, $values) {
    return array_intersect($array, (array)$values);
});