<?php

use Illuminate\Support\Arr;

/**
 * Apply the callback if the value is falsy.
 *
 * @param  bool  $value
 * @param  callable  $callback
 * @param  callable  $default
 * @return mixed
 */
Arr::macro('unless', function (array $array, bool $value, callable $callback, callable $default = null) {
    return Arr::when($array, !$value, $callback, $default);
});