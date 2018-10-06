<?php

use Illuminate\Support\Arr;

/**
 * Run a map over each nested chunk of items.
 *
 * @param  callable  $callback
 * @return static
 */
Arr::macro('mapSpread', function (array $array, callable $callback) {
    return Arr::map($array, function ($chunk) use ($callback) {
        return $callback(...$chunk);
    });
});