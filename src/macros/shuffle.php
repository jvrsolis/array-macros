<?php

use Illuminate\Support\Arr;

/**
 * Shuffle the items in the array.
 *
 * @param  int  $seed
 * @return static
 */
Arr::macro('shuffle', function ($array, $seed = null) {
    $items = $array;

    if (is_null($seed)) {
        shuffle($items);
    } else {
        srand($seed);

        usort($items, function () {
            return rand(-1, 1);
        });
    }

    return $items;
});