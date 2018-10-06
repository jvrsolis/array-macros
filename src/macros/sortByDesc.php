<?php

use Illuminate\Support\Arr;

/**
 * Sort the array in descending order using the given callback.
 *
 * @param  callable|string  $callback
 * @param  int  $options
 * @return static
 */
Arr::macro('sortByDesc', function (array $array, $callback, $options = SORT_REGULAR) {
    return static::sortBy($array, $callback, $options, true);
});