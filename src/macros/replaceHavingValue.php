<?php

use Illuminate\Support\Arr;

Arr::macro('replaceHavingValue', function (array $items, $operator, $value, $replacement = null) {
    if (func_num_args() === 3) {
        $replacement = $value;
        $value = $operator;
        $operator = '=';
    }

    return Arr::actHavingValue($items, $operator, $value, function ($item, $key) use ($replacement) {
        return $replacement;
    });
});