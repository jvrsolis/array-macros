<?php

use Illuminate\Support\Arr;

/**
 * Alias for the "avg" method.
 *
 * @param  callable|string|null  $callback
 * @return mixed
 */
Arr::macro('average', function (array $array, $callback = null) {
    return Arr::avg($array, $callback);
});