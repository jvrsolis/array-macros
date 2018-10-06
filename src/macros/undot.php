<?php

use Illuminate\Support\Arr;

/**
 * Expands a dotted associative array. The inverse of Arr::dot().
 *
 * @param  array $array
 * @return array
 */
Arr::macro('undot', function ($array) {
    $return = [];
    foreach ($array as $key => $value) {
        Arr::set($return, $key, $value);
    }
    return $return;
});