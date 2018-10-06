<?php

use Illuminate\Support\Arr;

Arr::macro('sumValue', function ($items, $value) {

    $value = $this->valueRetriever($value);

    return Arr::map($items, function ($item) use ($value) {
        return $item + $value;
    });
});