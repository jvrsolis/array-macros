<?php

use Illuminate\Support\Arr;

/**
 * Remove one or many array items from a given array using "dot" notation.
 *
 * @param  array  $array
 * @param  array|string  $keys
 * @return void
 */
Arr::macro('forget', function (&$array, $keys) {
    $original = &$array;

    $keys = (array)$keys;

    if (count($keys) === 0) {
        return;
    }

    foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
        if (Arr::exists($array, $key)) {
            unset($array[$key]);

            continue;
        }

        $parts = explode('.', $key);

            // clean up before each pass
        $array = &$original;

        while (count($parts) > 1) {
            $part = array_shift($parts);

            if (isset($array[$part]) && is_array($array[$part])) {
                $array = &$array[$part];
            } else {
                continue 2;
            }
        }

        unset($array[array_shift($parts)]);
    }
});