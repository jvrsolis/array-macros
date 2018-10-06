<?php

use Illuminate\Support\Arr;

Arr::macro('uppercase', function ($array) {
    return Arr::map($array, function ($item) {
        return strtoupper($item);
    });
});