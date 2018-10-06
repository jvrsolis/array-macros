<?php

use Illuminate\Support\Arr;

/**
 * Converts a model array into a multi-dataset series.
 * @param string $series The column containg the series labels.
 * @param string $label  The column containing the labels for each set.
 * @param string $data   The column containing the values for each set.
 * @param string $data   The aggregate function to run on the data column.
 */
Arr::macro('series', function ($series, $label, $value, $aggregate = null) {
    $grouped = Arr::groupBy($series);

    return Arr::transform($grouped, function ($seriesData, $seriesLabel) use ($label, $value, $aggregate) {
        return Arr::dataset($seriesData, $label, $value, $aggregate);
    });
});