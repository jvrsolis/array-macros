<?php

use Illuminate\Support\Arr;

/**
 * Converts a model array into a dataset.
 * @param string $label  The column containing the labels for each set.
 * @param string $data   The column containing the values for each set.
 */
Arr::macro('toDataSet', function ($array, $label, $value, $aggregate = null) {
    $groups = Arr::mapToGroups($array, function ($dataset) use ($label, $value) {
        return [$dataset[$label] => $dataset[$value]];
    });
    return Arr::map($groups, function ($group) use ($aggregate) {
        return Arr::aggregate($group, $aggregate);
    });
});