<?php

use Illuminate\Support\Arr;

Arr::macro('rotate', function (array &$array) {
    $element = array_shift($array);
    array_push($array, $element);
    return $element;
});