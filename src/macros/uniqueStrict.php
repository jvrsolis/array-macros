<?php

use Illuminate\Support\Arr;

/**
 * Return only unique items from the array array using strict comparison.
 *
 * @param  string|callable|null  $key
 * @return static
 */
Arr::macro('uniqueStrict', function (array $array) {
    return Arr::unique($array, $key, true);
});