<?php

use Illuminate\Support\Arr;

/**
 * Determine if an item exists in the array.
 *
 * @param  mixed  $key
 * @param  mixed  $operator
 * @param  mixed  $value
 * @return bool
 */
Arr::macro('contains', function ($array, $key, $operator = null, $value = null) {
    if (func_num_args() == 2) {
        if (Arr::useAsCallable($key)) {
            return !is_null(Arr::first($array, $key));
        }

        return in_array($key, $array);
    }

    if (func_num_args() == 3) {
        $value = $operator;

        $operator = '=';
    }

    return Arr::contains($array, Arr::operatorForWhere($key, $operator, $value));
});