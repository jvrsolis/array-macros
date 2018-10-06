<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair.
 *
 * @param  string  $key
 * @param  mixed  $values
 * @param  bool  $strict
 * @return array
 */
Arr::macro('havingNotIn', function (array $array, $key, $values, $strict = false) {
    $values = Arr::getArrayableItems($values);

    return Arr::reject($array, function ($item) use ($key, $values, $strict) {
        return in_array(data_get($item, $key), $values, $strict);
    });
});