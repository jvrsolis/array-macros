<?php

use Illuminate\Support\Arr;

/**
 * Execute a callback over each nested chunk of items.
 *
 * @param  callable  $callback
 * @return static
 */
Arr::macro('eachSpread', function (array $array, callable $callback) {
    return Arr::each($array, function ($chunk) use ($callback) {
        return $callback(...$chunk);
    });
});