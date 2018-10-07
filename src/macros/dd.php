<?php

use Illuminate\Support\Arr;

/**
 * Dump the collection and end the script.
 *
 * @return void
 */
Arr::macro('dd', function (...$args) {
    call_user_func_array([$this, 'dump'], $args);
    die(1);
});