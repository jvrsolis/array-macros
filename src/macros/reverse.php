<?php

use Illuminate\Support\Arr;

/**
 * Reverse items order.
 *
 * @return array
 */
Arr::macro('reverse', function ($array) {
    return array_reverse($array, true);
});