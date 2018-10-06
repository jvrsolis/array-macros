<?php

use Illuminate\Support\Arr;

/*
 * Dump the arguments given followed by the array.
 */
Arr::macro('dd', function (...$args) {
    call_user_func_array([$this, 'dump'], $args);
    die(1);
});