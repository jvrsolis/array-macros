<?php

use Illuminate\Support\Arr;

/**
 * Get the average value of a given key.
 *
 * @param  callable|string|null  $callback
 * @return mixed
 */
Arr::macro('avg', function (array $array, $callback = null) {
    if ($count = Arr::count($array)) {
        return Arr::sum($array, $callback) / $count;
    }
});