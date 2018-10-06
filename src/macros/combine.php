<?php

use Illuminate\Support\Arr;

/**
 * Create a array by using this array for keys and another for its values.
 *
 * @param  mixed  $values
 * @return static
 */
Arr::macro('combine', function ($array, $values) {
    return array_combine($array, Arr::getArrayableItems($values));
});