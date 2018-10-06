<?php

use Illuminate\Support\Arr;

/**
 * Computes the difference of arrays
 * recursively.
 *
 * @param array  $array
 * @param array  $array
 * @return array
 */
Arr::macro('diffRecursive', function ($arr1, $arr2) {
    $outputDiff = [];

    foreach ($arr1 as $key => $value) {
            //if the key exists in the second array, recursively call this function
            //if it is an array, otherwise check if the value is in arr2
        if (array_key_exists($key, $arr2)) {
            if (is_array($value)) {
                $recursiveDiff = array_diff_recursive($value, $arr2[$key]);

                if (count($recursiveDiff)) {
                    $outputDiff[$key] = $recursiveDiff;
                }
            } elseif (!in_array($value, $arr2)) {
                $outputDiff[$key] = $value;
            }
        } //if the key is not in the second array, check if the value is in
            //the second array (this is a quirk of how array_diff works)
        elseif (!in_array($value, $arr2)) {
            $outputDiff[$key] = $value;
        }
    }

    return $outputDiff;
});