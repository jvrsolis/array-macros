<?php

use Illuminate\Support\Arr;

/**
 * Put an item in the array by key.
 *
 * @param  mixed  $key
 * @param  mixed  $value
 * @return $array
 */
Arr::macro('put', function ($array, $key, $value) {
    return Arr::offsetSet($array, $key, $value);
});