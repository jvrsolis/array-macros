<?php

use Illuminate\Support\Arr;

/**
 * Cross join the given arrays,
 * returning all possible permutations.
 *
 * @param  array  ...$arrays
 * @return array
 */
Arr::macro('crossJoin', function (...$arrays) {
    $results = [[]];

    foreach ($arrays as $index => $array) {
        $append = [];

        foreach ($results as $product) {
            foreach ($array as $item) {
                $product[$index] = $item;

                $append[] = $product;
            }
        }

        $results = $append;
    }

    return $results;
});