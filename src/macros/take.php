<?php

use Illuminate\Support\Arr;

/**
 * Take the first or last {$limit} items.
 *
 * @param  int  $limit
 * @return static
 */
Arr::macro('take', function ($array, $limit) {
    if ($limit < 0) {
        return Arr::slice($array, $limit, abs($limit));
    }

    return Arr::slice($array, 0, $limit);
});