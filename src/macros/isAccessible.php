<?php

use Illuminate\Support\Arr;

/**
 * Determine whether the given value is array accessible.
 *
 * @param  mixed  $value
 * @return bool
 */
Arr::macro('isAccessible', function ($value) {
    return is_array($value) || $value instanceof ArrayAccess;
});