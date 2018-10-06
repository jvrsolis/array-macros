<?php


use Illuminate\Support\Arr;

/**
 * Merges the distinct elements of one or more arrays together so that the values
 * of one are appended to the end of the previous one.
 * It returns the resulting array.
 *
 * @param array  $array
 * @param array  $array
 * @return array
 */
Arr::macro('mergeRecursiveDistinct', function (array &$array1, array &$array2) {
    $merged = $array1;

    foreach ($array2 as $key => &$value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);
        } else {
            $merged[$key] = $value;
        }
    }

    return $merged;
});