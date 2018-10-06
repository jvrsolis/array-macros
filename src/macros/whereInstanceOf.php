<?php

use Illuminate\Support\Arr;

/**
 * Filter the items, removing any items that don't match the given type.
 *
 * @param  string  $type
 * @return static
 */
Arr::macro('whereInstanceOf', function ($array, $type) {
    return Arr::filter($array, function ($value) use ($type) {
        return $value instanceof $type;
    });
});