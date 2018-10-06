<?php

use Illuminate\Support\Arr;

/**
 * Add a "where not null" clause to the query.
 *
 * @param  string  $column
 * @param  string  $boolean
 * @return array
 */
Arr::macro('whereNotNull', function ($array, $column) {
    return Arr::where($array, $column, '!==', null);
});