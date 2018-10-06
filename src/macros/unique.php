<?php

use Illuminate\Support\Arr;

/**
 * Return only unique items from the array array.
 *
 * @param  string|callable|null  $key
 * @param  bool  $strict
 * @return static
 */
Arr::macro('unique', function (array $array, $key = null, $strict = false) {
    if (is_null($key)) {
        return array_unique($array, SORT_REGULAR);
    }

    $callback = Arr::valueRetriever($key);

    $exists = [];

    return Arr::reject($array, function ($item, $key) use ($callback, $strict, &$exists) {
        if (in_array($id = $callback($item, $key), $exists, $strict)) {
            return true;
        }

        $exists[] = $id;
    });
});