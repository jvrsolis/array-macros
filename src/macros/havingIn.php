<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair.
 *
 * @param  string  $key
 * @param  mixed  $values
 * @param  bool  $strict
 * @return static
 */
Arr::macro('havingIn', function (array $array, $key, $values, $strict = false) {
    $values = Arr::getArrayableItems($values);

    return Arr::filter($array, function ($item) use ($key, $values, $strict) {
        return in_array(data_get($item, $key), $values, $strict);
    });
});