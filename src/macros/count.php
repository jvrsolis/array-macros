<?php

use Illuminate\Support\Arr;

/**
 * Count the number of items in the array.
 *
 * @var    array
 * @return int
 */
Arr::macro('count', function (array $array) {
    return count($array);
});