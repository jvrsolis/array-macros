<?php

use Illuminate\Support\Arr;

/**
 * Get the items in the array that are not present in the given items.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('diff', function ($array, $items) {
    return array_diff($array, Arr::getArrayableItems($items));
});