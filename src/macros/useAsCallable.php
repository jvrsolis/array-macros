<?php

use Illuminate\Support\Arr;

/**
 * Determine if the given value is callable, but not a string.
 *
 * @param  mixed  $value
 * @return bool
 */
Arr::macro('useAsCallable', function ($value) {
    return !is_string($value) && is_callable($value);
});