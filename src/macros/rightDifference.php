<?php

use Illuminate\Support\Arr;

/**
 * Obtain the true right difference.
 *
 * In a venn diagram between A and B, this function
 * returns values found exclusively in B, but not
 * values shared between A and B.
 * (Right Only Venn Diagram)
 *
 * @param  array $a
 * @param  array $b
 * @return array
 */
Arr::macro('rightDifference', function (array $a, array $b) {
    $intersect = array_intersect($a, $b);
    return array_diff($b, $intersect);
});