<?php

use Illuminate\Support\Arr;

/*
 * Dump the arguments given followed by the array.
 */
Arr::macro('dump', function ($array) {
    $made = Arr::make(array_slice(func_get_args(), 1));
    $pushed = Arr::push($array, $made);
    $result = Arr::each($pushed, function ($item) {
        (new Dumper)->dump($item);
    });

    return $result;
});