<?php

use Illuminate\Support\Arr;

/**
 * Split a array into a certain number of groups.
 *
 * @param  int  $numberOfGroups
 * @return static
 */
Arr::macro('split', function ($array, int $numberOfGroups) {
    if (empty($array)) {
        return [];
    }

    $groups = [];

    $groupSize = floor(count($array) / $numberOfGroups);

    $remain = count($array) % $numberOfGroups;

    $start = 0;

    for ($i = 0; $i < $numberOfGroups; $i++) {
        $size = $groupSize;

        if ($i < $remain) {
            $size++;
        }

        if ($size) {
            array_push($groups, array_slice($this->items, $start, $size));

            $start += $size;
        }
    }

    return $groups;
});