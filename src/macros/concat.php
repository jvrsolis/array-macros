<?php

use Illuminate\Support\Arr;

/**
 * Push all of the given items onto the array.
 *
 * @param  \Traversable|array  $source
 * @return self
 */
Arr::macro('concat', function ($source) {
    $result = [];

    foreach ($source as $item) {
        Arr::push($result, $item);
    }

    return $result;
});