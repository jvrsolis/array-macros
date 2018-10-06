<?php

use Illuminate\Support\Arr;

/**
 * Obtain the true right union.
 *
 * In a venn diagram between A and B, this function
 * returns all values found exclusively in A and
 * values shared between A and B.
 * (Right and Center of Venn Diagram)
 *
 * @param  array $a
 * @param  array $b
 * @return array
 */
Arr::macro('rightUnion', function (array $a, array $b) {
    return array_merge(
        array_intersect($a, $b), // B that also belong to A
        array_diff($b, $a) // A without B
    );
});