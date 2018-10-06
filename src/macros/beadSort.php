<?php

Arr::macro('beadSort', function ($my_array) {
    $sortColumns = function ($my_array) {
        if (count($my_array) == 0) {
            return array();
        } elseif (count($my_array) == 1) {
            return array_chunk($my_array[0], 1);
        }

        array_unshift($my_array, null);
            // array_map(NULL, $my_array[0], $my_array[1], ...)
        $transpose = call_user_func_array('array_map', $my_array);
        return array_map('array_filter', $transpose);
    };

    foreach ($my_array as $e) {
        $poles[] = array_fill(0, $e, 1);
    }

    return array_map('count', $sortColumns($sortColumns($poles)));
});