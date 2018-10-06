<?php

use Illuminate\Support\Arr;

Arr::macro('isMulti', function ($array) {
    return count($array) != count($array, COUNT_RECURSIVE);
});