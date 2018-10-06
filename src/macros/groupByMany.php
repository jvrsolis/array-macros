<?php

use Illuminate\Support\Arr;

/**
 * Group an associative array by multiple fields or callbacks.
 *
 * @param  string|array  $groupBy
 * @param  bool  $preserveKeys
 * @return Collection
 */
Arr::macro('groupByMany', function (array $array, $groupBy, $preserveKeys = false) {
    if (!is_array($groupBy)) {
        $groupBy = [$groupBy];
    }
    $groupKeyRetrievers = [];
    foreach ($groupBy as $currentGroupBy) {
        $groupKeyRetrievers[] = Arr::valueRetriever($currentGroupBy);
    }
    $results = [];
    foreach ($array as $key => $value) {
        $currentLevel = [&$results];
        $nextLevel = [];
        foreach ($groupKeyRetrievers as $currentGroupBy) {
            $groupKeys = $currentGroupBy($value);
            if (!is_array($groupKeys)) {
                $groupKeys = [$groupKeys];
            }
            foreach ($groupKeys as $groupKey) {
                foreach ($currentLevel as &$subGroup) {
                    if (!array_key_exists($groupKey, $subGroup)) {
                        $subGroup[$groupKey] = [];
                    }
                    $nextLevel[] = &$subGroup[$groupKey];
                }
            }
            $currentLevel = $nextLevel;
            $nextLevel = [];
        }
        if ($preserveKeys && !is_null($key)) {
            foreach ($currentLevel as &$lastLevel) {
                $lastLevel[$key] = $value;
            }
        } else {
            foreach ($currentLevel as &$lastLevel) {
                $lastLevel[] = $value;
            }
        }
    }
    $toNestedCollection = function (&$array) use (&$toNestedCollection) {
        if (is_array($array)) {
            foreach ($array as &$subArray) {
                $subArray = $toNestedCollection($subArray);
            }
            return $array;
        } else {
            return $array;
        }
    };
    return $toNestedCollection($results);
});