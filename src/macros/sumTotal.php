<?php

use Illuminate\Support\Arr;

Arr::macro('sumTotal', function ($items) {
    return array_sum($items);
});