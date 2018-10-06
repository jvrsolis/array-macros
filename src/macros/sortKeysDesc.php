<?php

use Illuminate\Support\Arr;

/**
 * Sort the collection keys.
 *
 * @param  int  $options
 * @param  bool  $descending
 * @return static
 */
Arr::macro('sortKeysDesc', function ($items, $options = SORT_REGULAR) {
    return static::sortKeys($items, true);
});