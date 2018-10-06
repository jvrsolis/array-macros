<?php

use Illuminate\Support\Arr;

/**
 * Convert the array to its string representation.
 *
 * @return string
 */
Arr::macro('toString', function ($array) {
    return Arr::toJson($array);
});