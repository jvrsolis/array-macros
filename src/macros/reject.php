<?php

use Illuminate\Support\Arr;

/**
 * Create a array of all elements that do not pass a given truth test.
 *
 * @param  callable|mixed  $callback
 * @return static
 */
Arr::macro('reject', function (array $array, $callback) {
    if (Arr::useAsCallable($callback)) {
        return Arr::filter(function ($value, $key) use ($callback) {
            return !$callback($value, $key);
        });
    }

    return Arr::filter($array, function ($item) use ($callback) {
        return $item != $callback;
    });
});