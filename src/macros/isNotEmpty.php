<?php

use Illuminate\Support\Arr;

/**
 * Determine if the array is not empty.
 *
 * @return bool
 */
Arr::macro('isNotEmpty', function ($array) {
    return !Arr::isEmpty($array);
});