<?php

use Illuminate\Support\Arr;

/**
 * Intersect the array with the given items by key.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('intesectKey', function ($array, $items) {
    return array_intersect_key($array, Arr::getArrayableItems($items));
});