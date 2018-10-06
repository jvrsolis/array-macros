<?php

use Illuminate\Support\Arr;

/**
 * Add a "where not null" clause to the query.
 *
 * @param  string  $column
 * @param  string  $boolean
 * @return array
 */
Arr::macro('havingNotNull', function ($array, $column) {
    return Arr::having($array, $column, '!==', null);
});