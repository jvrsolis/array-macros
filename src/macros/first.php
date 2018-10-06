<?php

use Illuminate\Support\Arr;

Arr::macro('first', function (array $array, callable $callback = null, $default = null) {
    if (is_null($callback)) {
        if (empty($array)) {
            return value($default);
        }

        foreach ($array as $item) {
            return $item;
        }
    }

    foreach ($array as $key => $value) {
        if (call_user_func($callback, $value, $key)) {
            return $value;
        }
    }

    return value($default);
});