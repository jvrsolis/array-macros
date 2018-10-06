<?php

use Illuminate\Support\Arr;

/**
 * Transpose an array. Rows become columns, columns become rows.
 * E.g.     becomes
 *  [1,2]    [1,3]
 *  [3,4]    [2,4]
 *
 * @return array
 */
Arr::macro('transpose', function ($array) {
    return Arr::make(array_map(function (...$items) {
        return $items;
    }, ...Arr::values($array)));
});