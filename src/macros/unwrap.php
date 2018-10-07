<?php

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Get the underlying items from the given collection if applicable.
 *
 * @param  array|static  $value
 * @return array
 */
Arr::macro('unwrap', function ($array, $value) {
    return $value instanceof Arrayable ? $value->toArray() : $value;
});