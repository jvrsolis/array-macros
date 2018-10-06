<?php

use Illuminate\Support\Arr;

/**
 * Determine if the given value is callable, but not a string.
 *
 * @param  mixed  $value
 * @return bool
 */
Arr::macro('transform', function ($array, callable $callback) {
    return Arr::map($array, $callback);
});