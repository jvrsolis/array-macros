<?php

use Illuminate\Support\Arr;

Arr::macro('intersectKeyRecursive', function ($array1, $array2) {
    $array1 = array_intersect_key($array1, $array2);
    foreach ($array1 as $key => &$value) {
        if (is_array($value) && is_array($array2[$key])) {
            $value = array_intersect_key_recursive($value, $array2[$key]);
        }
    }
    return $array1;
});