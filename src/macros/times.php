<?php

use Illuminate\Support\Arr;

/**
 * Create a new array by invoking the callback a given number of times.
 *
 * @param  int  $number
 * @param  callable  $callback
 * @return static
 */
Arr::macro('times', function (array $array, int $number, callable $callback = null) {
    if ($number < 1) {
        return [];
    }

    if (is_null($callback)) {
        return range(1, $number);
    }

    return static::map(range(1, $number), $callback);
});