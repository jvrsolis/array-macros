<?php

use Illuminate\Support\Arr;

/**
 * Merge the array with the given items.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('merge', function ($array, $items) {
    return array_merge($array, Arr::getArrayableItems($items));
});