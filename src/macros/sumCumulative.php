<?php

use Illuminate\Support\Arr;

Arr::macro('sumCumulative', function (array $array, $callback = null) {
    if (is_null($callback)) {
        return array_sum($array);
    }

    $callback = Arr::valueRetriever($callback);

    return Arr::reduce($array, function ($result, $item) use ($callback) {
        return $result + $callback($item);
    }, 0);
});