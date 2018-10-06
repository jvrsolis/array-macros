<?php

use Illuminate\Support\Arr;

/**
 * Pluck an array of values from an array.
 *
 * @param  array  $array
 * @param  string|array  $value
 * @param  string|array|null  $key
 * @return array
 */
Arr::macro('pluck', function ($array, $value, $key = null) {
    $results = [];

    list($value, $key) = Arr::explodePluckParameters($value, $key);

    foreach ($array as $item) {
        $itemValue = data_get($item, $value);

            // If the key is "null", we will just append the value to the array and keep
            // looping. Otherwise we will key the array using the value of the key we
            // received from the developer. Then we'll return the final array form.
        if (is_null($key)) {
            $results[] = $itemValue;
        } else {
            $itemKey = data_get($item, $key);

            if (is_object($itemKey) && method_exists($itemKey, '__toString')) {
                $itemKey = (string)$itemKey;
            }

            $results[$itemKey] = $itemValue;
        }
    }

    return $results;
});