<?php

use Illuminate\Support\Arr;

Arr::macro('toAssoc', function ($array) {
    return Arr::reduce($array, function ($assoc, $keyValuePair) {
        list($key, $value) = $keyValuePair;
        $assoc[$key] = $value;
        return $assoc;
    }, []);
});