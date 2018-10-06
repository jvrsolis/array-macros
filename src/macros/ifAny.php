<?php

use Illuminate\Support\Arr;

/**
 * Execute a callable if the array isn't empty, then return the array.
 *
 * @param callable callback
 * @return \Illuminate\Support\Collection
 */
Arr::macro('ifAny', function (array $array, callable $callback) {
    if (!Arr::isEmpty($array)) {
        $callback($array);
    }
    return $array;
});