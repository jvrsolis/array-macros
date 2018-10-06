<?php

use Illuminate\Support\Arr;

/**
 * Search the array for a given value and return the corresponding key if successful.
 *
 * @param  mixed  $value
 * @param  bool  $strict
 * @return mixed
 */
Arr::macro('search', function (array $array, $value, $strict = false) {
    if (!Arr::useAsCallable($value)) {
        return array_search($value, $array, $strict);
    }

    foreach ($array as $key => $item) {
        if (call_user_func($value, $item, $key)) {
            return $key;
        }
    }

    return false;
});