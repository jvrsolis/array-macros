<?php

/*
 * Dump the contents of the array and terminate the script.
 */
Arr::macro('toCollectionRecursive', function ($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = Arr::toCollection($value);
            $array[$key] = $value;
        }
    }
    return collect($array);
});