<?php

use Illuminate\Support\Arr;

/**
 * Get and remove the first item from the array.
 *
 * @return mixed
 */
Arr::macro('shift', function ($array) {
    return array_shift($array);
});