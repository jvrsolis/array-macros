<?php

use Illuminate\Support\Arr;

/**
 * Get and remove the last item from the array.
 *
 * @return mixed
 */
Arr::macro('pop', function () {
    return array_pop($array);
});