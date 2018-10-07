<?php

use Illuminate\Support\Arr;

/*
 * Check whether a array doesn't contain any occurrences of a given
 * item, key-value pair, or passing truth test. `none` accepts the same
 * parameters as the `contains` array method.
 *
 * @see \Illuminate\Support\Arr::contains
 *
 * @param mixed $key
 * @param mixed $value
 *
 * @return bool
 */
Arr::macro('none', function ($array, $key, $value = null) {
    if (func_num_args() === 3) {
        return !Arr::contains($array, $key, $value);
    }
    return !Arr::contains($array, $key);
});