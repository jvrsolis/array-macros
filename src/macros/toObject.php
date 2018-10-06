<?php

use Illuminate\Support\Arr;

Arr::macro('toObject', function ($array) {
    return (object)$array;
});