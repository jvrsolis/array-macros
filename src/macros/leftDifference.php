<?php

use Illuminate\Support\Arr;

/**
 * Obtain the true left difference.
 *
 * In a venn diagram between A and B, this function
 * returns values found exclusively in A, but not
 * values shared between A and B.
 * (Left Only Venn Diagram)
 *
 * @param  array $a
 * @param  array $b
 * @return array
 */
Arr::macro('leftDifference', function (array $a, array $b) {
    $intersect = array_intersect($a, $b); // B in A
    return array_diff($a, $intersect); // A without (B in A)
});