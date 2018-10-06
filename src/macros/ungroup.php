<?php

use Illuminate\Support\Arr;

/**
 * Ungroup a previously grouped array (grouped by {@see Arr::groupBy()})
 */
Arr::macro('ungroup', function (array $array) {
        // create a new array to use as the array where the other arrays are merged into
    $newArray = Arr::make([]);

    Arr::each($array, function ($item) use (&$newArray) {
            // use merge to combine the arrays
        $newArray = Arr::merge($newArray, $item);
    });

    return $newArray;
});