<?php

use Illuminate\Support\Arr;

/**
 * Apply the callback if the value is truthy.
 *
 * @param  bool  $value
 * @param  callable  $callback
 * @param  callable  $default
 * @return mixed
 */
Arr::macro('when', function (array $array, bool $value, callable $callback, callable $default = null) {
    if ($value) {
        return $callback($array);
    } elseif ($default) {
        return $default($array);
    }

    return $array;
});