<?php

use Illuminate\Support\Arr;

Arr::macro('sumCallback', function (array $array, $callback = null) {
    $callback = $this->valueRetriever($callback);

    return $this->reduce(function ($result, $item) use ($callback) {
        return $result + $callback($item);
    }, 0);
});