<?php

use Illuminate\Support\Arr;

/**
 * Obtain the true left union.
 *
 * In a venn diagram between A and B, this function
 * returns all values found exclusively in A and and
 * commonly shared values.
 * (Left and Center of Venn Diagram)
 *
 * @param  array $a
 * @param  array $b
 * @return array
 */
Arr::macro('leftUnion', function (array $a, array $b) {
    return array_merge(
        array_intersect($a, $b), // B that also belong to A
        array_diff($a, $b) // A without B
    );
});