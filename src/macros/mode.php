<?php

use Illuminate\Support\Arr;

/**
 * Get the mode of a given key.
 *
 * @param  mixed  $key
 * @return array|null
 */
Arr::macro('mode', function (array $array, $key = null) {
    $count = Arr::count($array);

    if ($count == 0) {
        return;
    }

    $collection = isset($key) ? Arr::pluck($array, $key) : [];

    $counts = [];

    Arr::each($collection, function ($value) use ($counts) {
        $counts[$value] = isset($counts[$value]) ? $counts[$value] + 1 : 1;
    });

    $sorted = Arr::sort($counts);

    $highestValue = Arr::last($sorted);

    $filtered = Arr::filter($sorted, function ($value) use ($highestValue) {
        return $value == $highestValue;
    });

    $sorted = Arr::sort($filtered);

    $keys = Arr::keys($sorted);

    return Arr::all($keys);
});