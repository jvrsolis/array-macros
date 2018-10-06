<?php

use Illuminate\Support\Arr;

/**
 * Split a array into a certain number of groups.
 *
 * @param  int  $numberOfGroups
 * @return static
 */
Arr::macro('split', function ($array, int $numberOfGroups) {
    if (static::isEmpty($array)) {
        return [];
    }

    $groupSize = ceil(static::count($array) / $numberOfGroups);

    return Arr::chunk($array, $groupSize);
});