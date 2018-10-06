<?php

use Illuminate\Support\Arr;

/**
 * If the given value is not an array, wrap it in one.
 *
 * @param  mixed  $value
 * @return array
 */
Arr::macro('wrap', function ($value) {
    return !is_array($value) ? [$value] : $value;
});