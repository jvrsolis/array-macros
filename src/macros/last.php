<?php

use Illuminate\Support\Arr;

/**
 * Get the last item from the collection.
 *
 * @param  callable|null  $callback
 * @param  mixed  $default
 * @return mixed
 */
Arr::macro('last', function (array $array, callable $callback = null, $default = null) {
    if (is_null($callback)) {
        return empty($array) ? value($default) : end($array);
    }

    return Arr::first(array_reverse($array, true), $callback, $default);
});