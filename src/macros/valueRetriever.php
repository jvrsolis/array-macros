<?php

use Illuminate\Support\Arr;

/**
 * Get a value retrieving callback.
 *
 * @param  string  $value
 * @return callable
 */
Arr::macro('valueRetriever', function ($value) {
    if (Arr::useAsCallable($value)) {
        return $value;
    }
    $result = function ($item) use ($value) {
        return data_get($item, $value);
    };
    return $result;
});