<?php

use Illuminate\Support\Arr;

/**
 * Transpose (flip) a array matrix (array of arrays) while keeping its columns and row headers intact.
 *
 * Please note that a row missing a column another row does have can only occur for one column. It cannot
 * parse more than one missing column.
 */
Arr::macro('transposeWithKeys', function ($array, array $rows = null) {
    $rows = $rows ?? Arr::reduce(Arr::values($array), function (array $rows, array $values) {
        return array_unique(array_merge($rows, array_keys($values)));
    }, []);

    $keys = Arr::keys($array);

        // Transpose the matrix
    $items = array_map(function (...$items) use ($keys) {
            // The array's keys now become column headers
        return array_combine($keys, $items);
    }, ...Arr::values($array));

        // Add the new row headers
    $items = array_combine($rows, $items);

    return $items;
});