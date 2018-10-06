<?php

use Illuminate\Support\Arr;

Arr::macro('mergeFlat', function ($array, $callback) {
    return Arr::merge(
        $array,
        Arr::flatMap($array, function ($item) use ($callback) {
            return $callback($item);
        })
    );
});