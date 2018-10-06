<?php

use Illuminate\Support\Arr;

/**
 * Transpose an array.
 *
 * @return array
 *
 * @throws \LengthException
 */
Arr::macro('transposeStrict', function ($array) {
    $values = Arr::values($array);
    $expectedLength = count(Arr::first($array));
    $diffLength = count(array_intersect_key(...$values));
    if ($expectedLength !== $diffLength) {
        throw new \LengthException("Element's length must be equal.");
    }
    $items = array_map(function (...$items) {
        return $items;
    }, ...$values);
    return $items;
});