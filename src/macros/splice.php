<?php

use Illuminate\Support\Arr;

/**
 * Splice a portion of the array.
 *
 * @param  int  $offset
 * @param  int|null  $length
 * @param  mixed  $replacement
 * @return static
 */
Arr::macro('splice', function ($array, $offset, $length = null, $replacement = []) {
    if (func_num_args() == 1) {
        return array_splice($array, $offset);
    }

    return array_splice($array, $offset, $length, $replacement);
});