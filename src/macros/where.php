<?php

use Illuminate\Support\Arr;

/**
 * Filter items by the given key value pair.
 *
 * @param  string  $key
 * @param  mixed  $operator
 * @param  mixed  $value
 * @return static
 */
Arr::macro('where', function (array $array, $key, $operator, $value = null) {
    if (func_num_args() == 3) {
        $value = $operator;

        $operator = '=';
    }

    return Arr::filter($array, Arr::operatorForWhere($key, $operator, $value));
});