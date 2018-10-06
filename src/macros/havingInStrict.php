<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair using strict comparison.
 *
 * @param  string  $key
 * @param  mixed  $values
 * @return array
 */
Arr::macro('havingInStrict', function (array $array, $key, $value) {
    return Arr::havingIn($array, $key, $values, true);
});