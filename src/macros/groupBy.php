<?php

use Illuminate\Support\Arr;

/**
 * Group an associative array by a field or using a callback.
 *
 * @param  callable|string  $groupBy
 * @param  bool  $preserveKeys
 * @return static
 */
Arr::macro('groupBy', function (array $array, $groupBy, $preserveKeys = false) {
    if (is_array($groupBy)) {
        $nextGroups = $groupBy;

        $groupBy = array_shift($nextGroups);
    }

    $groupBy = Arr::valueRetriever($groupBy);
    $results = [];

    foreach ($array as $key => $value) {
        $groupKeys = $groupBy($value, $key);

        if (!is_array($groupKeys)) {
            $groupKeys = [$groupKeys];
        }

        foreach ($groupKeys as $groupKey) {
            $groupKey = is_bool($groupKey) ? (int)$groupKey : $groupKey;
            if (!key_exists($groupKey, $results)) {
                $results[$groupKey] = [];
            }

            $results[$groupKey] = Arr::offsetSet($results[$groupKey], $preserveKeys ? $key : null, $value);
        }
    }

    if (!empty($nextGroups)) {
        return Arr::map($result, Arr::groupBy($result, $nextGroups, $preserveKeys));
    }

    return $results;
});