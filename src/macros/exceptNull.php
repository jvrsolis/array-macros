<?php

use Illuminate\Support\Arr;

Arr::macro('exceptNull', function (array $array) {
    $filtered = Arr::filter($array, function ($item) {
        return !is_null($item);
    });

    return Arr::values($filtered);
});