<?php

use Illuminate\Support\Arr;

Arr::macro('bogoSort', function ($list) {
    $isSorted = function ($list) {
        $cnt = count($list);
        for ($j = 1; $j < $cnt; $j++) {
            if ($list[$j - 1] > $list[$j]) {
                return false;
            }
        }
        return true;
    };

    do {
        shuffle($list);
    } while (!$isSorted($list));
    return $list;
});