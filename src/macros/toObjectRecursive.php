<?php

use Illuminate\Support\Arr;

if (!Arr::hasMacro('toObjectRecursive')) {
    Arr::macro('toObjectRecursive', function ($array) {
        return json_decode(json_encode($array), false);
    });
}