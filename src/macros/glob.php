<?php

use Illuminate\Support\Arr;

/**
 * Execute a callable if the array isn't empty, then return the array.
 *
 * @param callable callback
 * @return \Illuminate\Support\Arr
 */
Arr::macro('glob', function (string $pattern, int $flags = 0) {
    return Arr::make(glob($pattern, $flags));
});