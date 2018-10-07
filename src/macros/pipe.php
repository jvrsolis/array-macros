<?php

use Illuminate\Support\Arr;

/**
 * Pass the collection to the given callback and return the result.
 *
 * @param  callable $callback
 * @return mixed
 */
Arr::macro('pipe', function ($array, callable $callback) {
    return $callback($array);
});