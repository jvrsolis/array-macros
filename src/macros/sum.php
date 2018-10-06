<?php

use Illuminate\Support\Arr;

Arr::macro('sum', function ($items, $value = null, $type = null) {
    if (is_numeric($value) || $type === 'value') {
        return Arr::sumValue($items, $value);
    }

    if (is_iterable($value) || $type === 'set') {
        return Arr::sumSets($items, $value);
    }

    if (is_callable($value) || $type === 'callable') {
        return Arr::sumCallback($items, $value);
    }

    if (is_null($value) && $type === 'cumulative') {
        return Arr::sumCumulative($items);
    }

    return Arr::sumTotal($items);
});