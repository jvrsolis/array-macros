<?php

use Illuminate\Support\Arr;

/**
 * Sort the collection keys.
 *
 * @param  int  $options
 * @param  bool  $descending
 * @return static
 */
Arr::macro('sortKeys', function ($items, $options = SORT_REGULAR, $descending = false) {

    $descending ? krsort($items, $options) : ksort($items, $options);

    return $items;
});