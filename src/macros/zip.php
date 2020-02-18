<?php

use Illuminate\Support\Arr;

/**
 * Zip the array together with one or more arrays.
 *
 * e.g. Arr::zip([1, 2, 3], [4, 5, 6]);
 *      => [[1, 4], [2, 5], [3, 6]]
 *
 * @param  mixed ...$items
 * @return static
 */
Arr::macro('zip', function ($array, $items) {
    $items = array_slice(func_get_args(), 1);

    $arrayableItems = array_map(function ($item) {
        return Arr::getArrayableItems($item);
    }, $items);

    $params = array_merge([function () use ($items) {
        return $items; //// TEST /////
    }, $array], $arrayableItems);

    return call_user_func_array('array_map', $params);
});