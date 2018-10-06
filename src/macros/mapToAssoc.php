<?php

use Illuminate\Support\Arr;

Arr::macro('mapToAssoc', function (array $array, $callback) {
    return Arr::assoc(Arr::map($array, $callback));
});