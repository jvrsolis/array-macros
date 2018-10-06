<?php

use Illuminate\Support\Arr;

/**
 * Merges the elements of one or more arrays together so that the values
 * of one are appended to the end of the previous one.
 * It returns the resulting array.
 *
 * @param array  $array
 * @param array  $array
 * @return array
 */
Arr::macro('mergeRecursive', function () {
    $args = func_get_args();

    return array_merge_recursive(...$args);
});