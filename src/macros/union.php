<?php

use Illuminate\Support\Arr;

/**
 * Obtain the true union two arrays
 *
 * In a venn diagram between A and B, this function
 * returns all values found exclusively in A and
 * exclusively in B and values shared between A and B.
 * (All Venn Diagram)
 *
 * @param  array  $a
 * @param  array  $b
 * @return array
 */
Arr::macro('union', function (array $a, array $b) {
    return array_merge(
        array_intersect($a, $b), // B that also belong to A
        array_diff($a, $b), // A without B
        array_diff($b, $a) // B without A
    );
});