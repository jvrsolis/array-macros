<?php

use Illuminate\Support\Arr;

/**
 * Run a grouping map over the items.
 *
 * The callback should return an associative array with a single key/value pair.
 *
 * @param  callable  $callback
 * @return static
 */
Arr::macro('mapToGroups', function (array $array, callable $callback) {
    $mapped = Arr::map($array, $callback);

    $groups = Arr::reduce($mapped, function ($groups, $pair) {
        $groups[key($pair)][] = reset($pair);
        return $groups;
    }, []);

    return $groups;
});