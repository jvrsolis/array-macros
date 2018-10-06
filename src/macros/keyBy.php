<?php

use Illuminate\Support\Arr;

/**
 * Key an associative array by a field or using a callback.
 *
 * @param  callable|string  $keyBy
 * @return static
 */
Arr::macro('keyBy', function (array $array, $keyBy) {
    $keyBy = Arr::valueRetriever($keyBy);

    $results = [];

    foreach ($array as $key => $item) {
        $resolvedKey = $keyBy($item, $key);

        if (is_object($resolvedKey)) {
            $resolvedKey = (string)$resolvedKey;
        }

        $results[$resolvedKey] = $item;
    }

    return $results;
});