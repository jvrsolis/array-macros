<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair using strict comparison.
 *
 * @param  string  $key
 * @param  mixed  $value
 * @return static
 */
Arr::macro('whereStrict', function (array $array, $key, $value) {
    return Arr::where($array, $key, '===', $value);
});