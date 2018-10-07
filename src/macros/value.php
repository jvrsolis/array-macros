<?php

use Illuminate\Support\Arr;

/**
 * Get a single column's value from the first result of a query.
 *
 * @param  string  $column
 * @return mixed
 */
Arr::macro('value', function ($array, $column) {
    if ($result = Arr::first($array, [$column])) {
        return $result[$column];
    }
});