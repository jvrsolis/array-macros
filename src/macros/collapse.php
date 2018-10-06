<?php

use Illuminate\Support\Arr;

/**
 * Collapse an array of arrays into a single array.
 *
 * @param  array  $array
 * @return array
 */
Arr::macro('collapse', function ($array) {
    $results = [];

    foreach ($array as $values) {
        if ($values instanceof Collection) {
            $values = $values->all();
        } elseif (!is_array($values)) {
            continue;
        }

        $results = array_merge($results, $values);
    }

    return $results;
});