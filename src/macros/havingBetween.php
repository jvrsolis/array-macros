<?php

use Illuminate\Support\Arr;

Arr::macro('havingBetween', function ($array, $column, array $values, bool $inclusive = false) {
    $values = array_values($values);

    if (count($values) !== 2) {
        return $this;
    }

    Arr::filter($array, function ($item) use ($values, $column, $inclusive) {
        if ($inclusive) {
            return (data_get($item, $column) >= $values[0]) && (data_get($item, $column) <= $values[1]);
        }
        return (data_get($item, $column) > $values[0]) && (data_get($item, $column) < $values[1]);
    });
});