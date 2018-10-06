<?php

use Illuminate\Support\Arr;

/**
 * Reduce the array to a single value.
 *
 * @param  callable  $callback
 * @param  mixed  $initial
 * @return mixed
 */
Arr::macro('reduce', function (array $array, callable $callback, $initial = null) {
    return array_reduce($array, $callback, $initial);
});