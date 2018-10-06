<?php

use Illuminate\Support\Arr;

/**
 * Get the items in the array whose keys and values are not present in the given items.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('intersectUsing', function ($array, $items) {
    return array_uintersect($items, $Arr::getArrayableItems($items), $callback);
});