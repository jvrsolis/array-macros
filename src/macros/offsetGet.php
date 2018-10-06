<?php

use Illuminate\Support\Arr;

/**
 * Get an item at a given offset.
 *
 * @param  mixed  $key
 * @return mixed
 */
Arr::macro('offsetGet', function ($array, $key) {
    return $array[$key];
});