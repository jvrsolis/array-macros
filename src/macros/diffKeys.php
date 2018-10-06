<?php

use Illuminate\Support\Arr;

/**
 * Get the items in the array whose keys are not present in the given items.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('diffKeys', function ($array, $items) {
    return array_diff_key($array, Arr::getArrayableItems($items));
});