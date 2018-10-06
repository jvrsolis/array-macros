<?php

use Illuminate\Support\Arr;

/**
 * Divide an array into two arrays. One with keys and the other with values.
 *
 * @param  array  $array
 * @return array
 */
Arr::macro('divide', function ($array) {
    return [array_keys($array), array_values($array)];
});