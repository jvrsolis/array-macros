<?php

use Illuminate\Support\Arr;

/**
 * Sort through each item with a callback.
 *
 * @param  callable|null  $callback
 * @return static
 */
Arr::macro('sort', function (array $array, callable $callback = null) {
    $items = $array;

    $callback
        ? uasort($items, $callback)
        : asort($items);

    return $items;
});