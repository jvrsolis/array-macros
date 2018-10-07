<?php

use Illuminate\Support\Arr;

/*
 * Create a new array with the specified amount of items
 *
 * @param int $size
 *
 * @return \Illuminate\Support\Arr
 */
Arr::macro('withSize', function (int $size) {
    if ($size < 1) {
        return [];
    }
    return range(1, $size);
});