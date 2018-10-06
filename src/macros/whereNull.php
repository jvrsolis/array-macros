<?php

use Illuminate\Support\Arr;

/**
 * Add an "where null" clause to the query.
 *
 * @param  string  $column
 * @return array
 */
Arr::macro('whereNull', function ($array, $column) {
    return Arr::where($array, $column, '===', null);
});