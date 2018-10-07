<?php

use Illuminate\Support\Arr;

/**
 * Partition the collection into two arrays using the given callback or key.
 *
 * @param  callable|string  $key
 * @param  mixed  $operator
 * @param  mixed  $value
 * @return static
 */
Arr::macro('partition', function ($array, $key, $operator = null, $value = null) {
    $partitions = [[], []];

    $callback = func_num_args() === 1
        ? Arr::valueRetriever($key)
        : Arr::operatorForWhere(...func_get_args());

    foreach ($array as $key => $item) {
        $partitions[(int)!$callback($item, $key)][$key] = $item;
    }

    return $partitions;
});