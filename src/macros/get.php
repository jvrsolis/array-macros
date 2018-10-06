<?php

use Illuminate\Support\Arr;

/**
 * Get an item from an array using "dot" notation.
 *
 * @param  \ArrayAccess|array  $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
Arr::macro('get', function ($array, $key, $default = null) {
    if (!Arr::accessible($array)) {
        return value($default);
    }

    if (is_null($key)) {
        return $array;
    }

    if (Arr::exists($array, $key)) {
        return $array[$key];
    }

    foreach (explode('.', $key) as $segment) {
        if (Arr::accessible($array) && Arr::exists($array, $segment)) {
            $array = $array[$segment];
        } else {
            return value($default);
        }
    }

    return $array;
});