<?php

use Illuminate\Support\Arr;

/**
 * Check if an item or items exist in an array using "dot" notation.
 *
 * @param  \ArrayAccess|array  $array
 * @param  string|array  $keys
 * @return bool
 */
Arr::macro('has', function ($array, $keys) {
    if (is_null($keys)) {
        return false;
    }

    $keys = (array)$keys;

    if (!$array) {
        return false;
    }

    if ($keys === []) {
        return false;
    }

    foreach ($keys as $key) {
        $subKeyArray = $array;

        if (Arr::exists($array, $key)) {
            continue;
        }

        foreach (explode('.', $key) as $segment) {
            if (Arr::accessible($subKeyArray) && Arr::exists($subKeyArray, $segment)) {
                $subKeyArray = $subKeyArray[$segment];
            } else {
                return false;
            }
        }
    }

    return true;
});