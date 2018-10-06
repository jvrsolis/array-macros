<?php

use Illuminate\Support\Arr;

/**
 * Get the previous item from the array.
 *
 * @param mixed $currentItem
 * @param mixed $fallback
 *
 * @return mixed
 */
Arr::macro('before', function (array $array, $currentItem, $fallback = null) {
    $reversed = Arr::reverse($array);
    return Arr::after($reversed, $currentItem, $fallback);
});