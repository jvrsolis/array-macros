<?php

use Illuminate\Support\Arr;

/**
 * Run a filter over each of the items.
 *
 * @param  callable|null  $callback
 * @return static
 */
Arr::macro('filter', function (array $array, callable $callback = null) {
    if ($callback) {
        return Arr::where($array, $callback);
    }

    return array_filter($array);
});