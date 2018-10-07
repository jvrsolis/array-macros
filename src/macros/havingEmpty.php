<?php

use Illuminate\Support\Arr;

Arr::macro('havingEmpty', function ($array) {
    return Arr::filter($array, function ($value) use ($column) {
        return empty(data_get($value, $column));
    });
});