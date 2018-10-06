<?php

use Illuminate\Support\Arr;

/**
 * Get a subset of the items from the given array.
 *
 * @param  array         $array
 * @param  array|string  $items
 * @param  bool          $keys
 * @return array
 */
Arr::macro('only', function (array $array, $items, $keys = true) {
    if ($keys) {
        return Arr::onlyKeys($array, $items);
    }
    return Arr::onlyValues($array, $items);
});