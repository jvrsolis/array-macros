<?php

use Illuminate\Support\Arr;

/**
 * Get the items in the array whose keys and values are not present in the given items.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('intersectAssoc', function ($array, $items) {
    return array_intersect_assoc($array, Arr::getArrayableItems($items));
});