<?php

use Illuminate\Support\Arr;

/**
 * Run a map over each of the items.
 *
 * @param  callable  $callback
 * @return static
 */
Arr::macro('map', function (array $array, callable $callback) {
    $keys = array_keys($array);

    $items = array_map($callback, $array, $keys);

    return array_combine($keys, $items);
});