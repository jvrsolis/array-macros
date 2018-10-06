<?php

use Illuminate\Support\Arr;

Arr::macro('select', function ($array, $keys) {
    return Arr::map($array, function ($item) use ($keys) {
        $list = [];
        foreach ($keys as $key) {
            $arr = explode(".", $key);
            $last = end($arr);
            $list[$last] = data_get($item, $key);
        }
        return $list;
    });
});