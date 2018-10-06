<?php

use Illuminate\Support\Arr;

/**
 * Returns a value indicating whether the given array is an indexed array.
 *
 * An array is indexed if all its keys are integers. If `$consecutive` is true,
 * then the array keys must be a consecutive sequence starting from 0.
 *
 * Note that an empty array will be considered indexed.
 *
 * @param array $array the array being checked
 * @param bool $consecutive whether the array keys must be a consecutive sequence
 * in order for the array to be treated as indexed.
 * @return bool whether the array is associative
 */
Arr::macro('isIndexed', function (array $array, bool $consecutive = false) {
    if (!is_array($array)) {
        return false;
    }
    if (empty($array)) {
        return true;
    }
    if ($consecutive) {
        return array_keys($array) === range(0, count($array) - 1);
    } else {
        foreach ($array as $key => $value) {
            if (!is_int($key)) {
                return false;
            }
        }
        return true;
    }
});