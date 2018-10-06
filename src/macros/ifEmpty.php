<?php

use Illuminate\Support\Arr;

/**
 * Execute a callable if the array is empty, then return the array.
 *
 * @param callable $callback
 *
 * @return \Illuminate\Support\Collection
 */
Arr::macro('ifEmpty', function ($array, callable $callback) {
    if (Arr::isEmpty($array)) {
        $callback($array);
    }
    return $array;
});