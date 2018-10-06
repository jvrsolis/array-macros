<?php

use Illuminate\Support\Arr;

/**
 * Set the item at a given offset.
 *
 * @param  mixed  $key
 * @param  mixed  $value
 * @return void
 */
Arr::macro('offsetSet', function ($array, $key, $value) {
    if (is_null($key)) {
        $array[] = $value;
    } else {
        $array[$key] = $value;
    }

    return $array;
});