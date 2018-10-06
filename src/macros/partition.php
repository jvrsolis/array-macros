<?php

use Illuminate\Support\Arr;

/**
 * Partition the array into two arrays using the given callback or key.
 *
 * @param  callable|string  $callback
 * @return static
 */
Arr::macro('partition', function ($array) {
    $partitions = [[], []];

    $callback = Arr::valueRetriever($callback);

    foreach ($array as $key => $item) {
        $partitions[(int)!$callback($item)][$key] = $item;
    }

    return $partitions;
});