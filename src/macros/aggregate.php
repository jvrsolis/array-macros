<?php

use Illuminate\Support\Arr;

/**
 * Call an aggregate function on an array.
 *
 * @param array $array
 * @param string $aggregate
 * @return array
 */
Arr::macro('aggregate', function ($array, $aggregate) {
    if (is_callable($aggregate)) {
        return $aggregate($array);
    }
    if (strtolower($aggregate) == 'sum') {
        return Arr::sum($array);
    } elseif (strtolower($aggregate) == 'count') {
        return Arr::count($array);
    } elseif (strtolower($aggregate) == 'max') {
        return Arr::max($array);
    } elseif (strtolower($aggregate) == 'min') {
        return Arr::min($array);
    } elseif (strtolower($aggregate) == 'avg') {
        return Arr::avg($array);
    } else {
        return $array;
    }
});