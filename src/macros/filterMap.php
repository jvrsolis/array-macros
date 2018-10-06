<?php

use Illuminate\Support\Arr;

/**
 * Map an array, then filter the results.
 *
 * @param callable $map
 * @param callable $filter
 *
 * @return array
 */
Arr::macro('filterMap', function ($array, $map, $filter = null) {
    $mapped = Arr::map($array, $map);
    return Arr::filter($array, $filter);
});