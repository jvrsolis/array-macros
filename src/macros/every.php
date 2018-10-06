<?php

use Illuminate\Support\Arr;

/**
 * Determine if all items in the array pass the given test.
 *
 * @param  string|callable  $key
 * @param  mixed  $operator
 * @param  mixed  $value
 * @return bool
 */
Arr::macro('every', function ($array, $key, $operator = null, $value = null) {
    if (func_num_args() == 2) {
        $callback = Arr::valueRetriever($key);

        foreach ($array as $k => $v) {
            if (!$callback($v, $k)) {
                return false;
            }
        }

        return true;
    }

    if (func_num_args() == 3) {
        $value = $operator;

        $operator = '=';
    }

    return Arr::every(Arr::operatorForWhere($key, $operator, $value));
});