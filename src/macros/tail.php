<?php

use Illuminate\Support\Arr;

/**
 * Get the tail of a array, everything except the first item.
 *
 * @param bool $preserveKeys
 *
 * @return \Illuminate\Support\Arr
 */
Arr::macro('tail', function ($array, bool $preserveKeys = false) {
    return !$preserveKeys ? Arr::values(Arr::slice($array, 1)) : Arr::slice($array, 1);
});