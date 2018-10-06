<?php

use Illuminate\Support\Arr;

Arr::macro('replaceHaving', function (array $items, $key, $operator, $value, $replacement = null) {
    if (func_num_args() === 4) {
        $replacement = $value;
        $value = $operator;
        $operator = '=';
    }

    return Arr::actHaving($items, $key, $operator, $value, function ($item, $key) use ($replacement) {
        return $replacement;
    });
});