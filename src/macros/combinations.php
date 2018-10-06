<?php

use Illuminate\Support\Arr;

Arr::macro('combinations', function ($array) {
    $results = array(array());

    foreach ($array as $element) {
        foreach ($results as $combination) {
            array_push($results, array_merge(array($element), $combination));
        }
    }

    return $results;
});