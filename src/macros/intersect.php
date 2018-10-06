<?php

use Illuminate\Support\Arr;

/**
 * Intersect the array with the given items.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('intersect', function ($array, $items) {
    return array_intersect($array, Arr::getArrayableItems($items));
});