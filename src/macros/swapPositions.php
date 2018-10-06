<?php

use Illuminate\Support\Arr;

/**
 * Swap the position of two values in an array.
 *
 * @return array
 */
Arr::macro('swapPositions', function ($data, $left, $right) {
    $backup_old_data_right_value = $data[$right];
    $data[$right] = $data[$left];
    $data[$left] = $backup_old_data_right_value;
    return $data;
});