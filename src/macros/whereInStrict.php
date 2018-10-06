<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair using strict comparison.
 *
 * @param  string  $key
 * @param  mixed  $values
 * @return array
 */
Arr::macro('whereInStrict', function (array $array, $key, $value) {
    return Arr::whereIn($array, $key, $values, true);
});