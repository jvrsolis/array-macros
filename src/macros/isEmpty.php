<?php

use Illuminate\Support\Arr;

/**
 * Determine if the array is empty or not.
 *
 * @return bool
 */
Arr::macro('isEmpty', function ($array) {
    return empty($array);
});