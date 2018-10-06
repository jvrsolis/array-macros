<?php

use Illuminate\Support\Arr;

/**
 * Map a array and flatten the result by a single level.
 *
 * @param  callable  $callback
 * @return static
 */
Arr::macro('flatMap', function (array $array, callable $callback) {
    $mapped = Arr::map($array, $callback);
    return Arr::collapse($mapped);
});