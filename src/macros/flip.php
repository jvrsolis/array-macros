<?php

use Illuminate\Support\Arr;

/**
 * Flip the items in the array.
 *
 * @return array
 */
Arr::macro('flip', function ($array) {
    return array_flip($array);
});