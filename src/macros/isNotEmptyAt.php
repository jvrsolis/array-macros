<?php

use Illuminate\Support\Arr;

/**
 * Determine if the given key exists in the provided array.
 *
 * @param  \ArrayAccess|array  $array
 * @param  string|int  $key
 * @return bool
 */
Arr::macro('isNotEmptyAt', function ($array, $key) {
    if ($array instanceof ArrayAccess) {
        return $array->offsetExists($key) && empty($array[$key]);
    }

    return array_key_exists($key, $array) && !empty($array[$key]);
});