<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair using strict comparison.
 *
 * @param  string  $key
 * @param  mixed  $value
 * @return static
 */
Arr::macro('havingStrict', function (array $array, $key, $value) {
    return Arr::having($array, $key, '===', $value);
});