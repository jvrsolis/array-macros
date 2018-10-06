<?php

use Illuminate\Support\Arr;

/**
 * Get the next item from the array.
 *
 * @param mixed $currentItem
 * @param mixed $fallback
 *
 * @return mixed
 */
Arr::macro('after', function (array $array, $currentItem, $fallback = null) {
    $currentKey = Arr::search($array, $currentItem, true);
    if ($currentKey === false) {
        return $fallback;
    }
    $currentKeys = Arr::keys($array);

    $currentOffset = Arr::search($currentKeys, $currentKey, true);

    $next = Arr::slice($array, $currentOffset, 2);

    if (Arr::count($next) < 2) {
        return $fallback;
    }
    return Arr::last($next);
});