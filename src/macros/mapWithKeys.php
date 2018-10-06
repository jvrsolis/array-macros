<?php

use Illuminate\Support\Arr;

/**
 * Run an associative map over each of the items.
 *
 * The callback should return an associative array with a single key/value pair.
 *
 * @param  callable  $callback
 * @return static
 */
Arr::macro('mapWithKeys', function (array $array, callable $callback) {
    $result = [];

    foreach ($array as $key => $value) {
        $assoc = $callback($value, $key);

        foreach ($assoc as $mapKey => $mapValue) {
            $result[$mapKey] = $mapValue;
        }
    }

    return $result;
});