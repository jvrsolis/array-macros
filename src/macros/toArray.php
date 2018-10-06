<?php

use Illuminate\Support\Arr;

/**
 * Get the array of items as a plain array.
 *
 * @return array
 */
Arr::macro('toArray', function ($array) {
    return array_map(function ($value) {
        return $value instanceof Arrayable ? $value->toArray() : $value;
    }, $array);
});