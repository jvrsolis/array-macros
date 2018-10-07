<?php

use Illuminate\Support\Arr;

/**
 * An extension to the where methods
 * available in the array.
 *
 * Returns first result found.
 */
Arr::macro('firstHaving', function ($array, $key, $operator, $value = null) {
    return Arr::first(Arr::filter($array, Arr::operatorForHaving($array, $key, $operator, $value)));
});