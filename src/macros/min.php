<?php

use Illuminate\Support\Arr;

/**
 * Get the min value of a given key.
 *
 * @param  callable|string|null  $callback
 * @return mixed
 */
Arr::macro('min', function (array $array, $callback = null) {
    $callback = Arr::valueRetriever($callback);

    $mapped = Arr::map($array, function ($value) use ($callback) {
        return $callback($value);
    });

    $filter = Arr::filter($mapped, function ($value) {
        return !is_null($value);
    });


    return Arr::reduce($filter, function ($result, $item) use ($callback) {
        $value = $callback($item);
        return is_null($result) || $value < $result ? $value : $result;
    });
});