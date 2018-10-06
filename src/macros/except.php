<?php

use Illuminate\Support\Arr;

Arr::macro('except', function ($array, $keys) {
    Arr::forget($array, $keys);

    return $array;
});