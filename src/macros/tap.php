<?php

use Illuminate\Support\Arr;

/**
 * Pass the array to the given callback and then return it.
 *
 * @param  callable  $callback
 * @return $array
 */
Arr::macro('tap', function (array $array, callable $callback) {
    return $callback($array);
});