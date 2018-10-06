<?php

use Illuminate\Support\Arr;

/**
 * Determine if an item exists in the array using strict comparison.
 *
 * @param  mixed  $key
 * @param  mixed  $value
 * @return bool
 */
Arr::macro('containsStrict', function ($array, $key, $value = null) {
    if (func_num_args() == 3) {
        return Arr::contains($array, function ($item) use ($key, $value) {
            return data_get($item, $key) === $value;
        });
    }

    if (Arr::useAsCallable($key)) {
        return !is_null(Arr::first($array, $key));
    }

    return in_array($key, $array, true);
});