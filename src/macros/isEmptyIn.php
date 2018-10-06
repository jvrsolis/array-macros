<?php

use Illuminate\Support\Arr;

/**
 * Determine if the given key exists in the provided array.
 *
 * @param  \ArrayAccess|array  $array
 * @param  string|int  $key
 * @return bool
 */
Arr::macro('isEmptyIn', function ($array, $keys) {
    $isEmptyIn = false;

    foreach ($keys as $key) {
        if ($isEmptyIn == true) {
            break;
        }

        $isEmptyIn = $isEmptyIn || Arr::isEmptyAt($array, $key);
    }

    return $isEmptyIn;
});