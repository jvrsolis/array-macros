<?php

use Illuminate\Support\Arr;

Arr::macro('dot', function ($array, $prepend = '') {
    $results = [];

    foreach ($array as $key => $value) {
        if (is_array($value) && !empty($value)) {
            $results = array_merge($results, Arr::dot($value, $prepend . $key . '.'));
        } else {
            $results[$prepend . $key] = $value;
        }
    }

    return $results;
});