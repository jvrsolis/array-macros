<?php

use Illuminate\Support\Arr;

/**
 * Collapse an array of arrays into a single array,
 * avoids using array_merge to preserve the keys.
 *
 * @param  array $array
 * @return array
 */
Arr::macro('collapseWithKeys', function ($array) {
    $result = [];

    foreach ($array as $child) {
        if (is_array($child)) {
            foreach ($child as $key => $value) {
                $result[$key] = $value;
            }
        }
    }

    return $result;
});