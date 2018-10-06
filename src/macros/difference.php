<?php

use Illuminate\Support\Arr;

/**
 * Obtain the true difference of two arrays.
 *
 * In a venn diagram between A and B, this function
 * returns exclusive values of both A and B, but
 * not values shared between A and B.
 * (Left and Right Only Venn Diagram)
 *
 * @param  array  $a
 * @param  array  $b
 * @return array
 */
Arr::macro('difference', function (array $a, array $b) {
    $intersect = array_intersect($a, $b);
    return array_merge(array_diff($a, $intersect), array_diff($b, $intersect));
});