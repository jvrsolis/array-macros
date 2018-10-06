<?php

use Illuminate\Support\Arr;

/**
 * Map the values into a new class.
 *
 * @param  string  $class
 * @return static
 */
Arr::macro('mapInto', function ($array, $class) {
    return Arr::map($array, function ($value, $key) use ($class) {
        return new $class($value, $key);
    });
});