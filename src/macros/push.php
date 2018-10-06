<?php

use Illuminate\Support\Arr;

/**
 * Push an item onto the end of the array.
 *
 * @param  mixed  $value
 * @return $array
 */
Arr::macro('push', function ($array, $value) {
    return Arr::offsetSet($array, null, $value);
});