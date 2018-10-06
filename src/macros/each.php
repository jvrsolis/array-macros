<?php

use Illuminate\Support\Arr;

/**
 * Execute a callback over each item.
 *
 * @param  callable  $callback
 * @return $array
 */
Arr::macro('each', function (array $array, callable $callback) {
    foreach ($array as $key => $item) {
        $array[$key] = $callback($item, $key);
    }
    return $array;
});