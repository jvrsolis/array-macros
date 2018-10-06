<?php

use Illuminate\Support\Arr;

/**
 * Flatten a multi-dimensional array into a single level.
 *
 * @param  array  $array
 * @param  int  $depth
 * @return array
 */
Arr::macro('flatten', function ($array) {
    return array_reduce($array, function ($result, $item) use ($depth) {
        $item = $item instanceof Collection ? $item->all() : $item;

        if (!is_array($item)) {
            return array_merge($result, [$item]);
        } elseif ($depth === 1) {
            return array_merge($result, array_values($item));
        } else {
            return array_merge($result, Arr::flatten($item, $depth - 1));
        }
    }, []);
});