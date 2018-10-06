<?php

use Illuminate\Support\Arr;

Arr::macro('intersectRecursive', function ($array) {
    foreach (func_get_args() as $arg) {
        $args[] = array_map('serialize', $arg);
    }
    $result = call_user_func_array('array_intersect', $args);

    return array_map('unserialize', $result);
});