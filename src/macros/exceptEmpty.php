<?php

use Illuminate\Support\Arr;

Arr::macro('exceptEmpty', function (array $array) {
    $filtered = Arr::filter($array, function ($item) {
        return !empty($item);
    });

    return Arr::values($filtered);
});