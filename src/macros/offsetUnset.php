<?php

use Illuminate\Support\Arr;

/**
 * Unset the item at a given offset.
 *
 * @param  string  $key
 * @return void
 */
Arr::macro('offsetUnset', function ($array, $key) {
    unset($array[$key]);
    return $array;
});