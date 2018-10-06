<?php

use Illuminate\Support\Arr;

/**
 * Determine if the given key exists in the provided array.
 *
 * @param  \ArrayAccess|array  $array
 * @param  string|int  $key
 * @return bool
 */
Arr::macro('isNotEmptyIn', function ($array, $keys) {
    $isNotEmptyIn = true;

    foreach ($keys as $key) {
        if ($isNotEmptyIn == false) {
            break;
        }
        $isNotEmptyIn = $isNotEmptyIn && Arr::isNotEmptyAt($array, $key);
    }

    return $isNotEmptyIn;
});