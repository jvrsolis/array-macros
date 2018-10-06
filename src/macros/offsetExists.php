<?php

use Illuminate\Support\Arr;

/**
 * Determine if an item exists at an offset.
 *
 * @param  mixed  $key
 * @return bool
 */
Arr::macro('offsetExists', function ($array, $key) {
    return array_key_exists($key, $array);
});