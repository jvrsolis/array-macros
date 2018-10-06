<?php

use Illuminate\Support\Arr;

Arr::macro('sumSets', function () {
    $arrays = func_get_args();

    $keys = array_keys(array_reduce($arrays, function ($keys, $arr) {
        return $keys + $arr;
    }, array()));

    $sums = array();

    foreach ($keys as $key) {
        $sums[$key] = array_reduce($arrays, function ($sum, $arr) use ($key) {
            return $sum + @$arr[$key];
        });
    }
    return $sums;
});