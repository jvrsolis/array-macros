<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair using strict comparison.
 *
 * @param  string  $key
 * @param  mixed  $values
 * @return array
 */
Arr::macro('whereNotInStrict', function (array $array, $key, $values) {
    return Arr::whereNotIn($array, $key, $values, true);
});