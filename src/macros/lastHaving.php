<?php

use Illuminate\Support\Arr;

/**
 * An extension to the where methods
 * available in the array.
 *
 * Returns first result found.
 */
Arr::macro('lastHaving', function ($array, $key, $operator, $value = null) {

    if (func_num_args() == 2) {
        $value = $operator;

        $operator = '=';
    }

    return Arr::last(Arr::filter($array, Arr::operatorForHaving($array, $key, $operator, $value)));
});