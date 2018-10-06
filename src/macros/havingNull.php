<?php

use Illuminate\Support\Arr;

/**
 * Add an "where null" clause to the query.
 *
 * @param  string  $column
 * @return array
 */
Arr::macro('havingNull', function ($array, $column) {
    return Arr::having($array, $column, '===', null);
});