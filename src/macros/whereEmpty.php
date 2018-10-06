<?php

use Illuminate\Support\Arr;

/**
 * Add an "where null" clause to the query.
 *
 * @param  string  $column
 * @return array
 */
Arr::macro('whereEmpty', function ($array, $column) {
    return Arr::filter($array, function ($value) use ($column) {
        return empty(data_get($value, $column));
    });
});