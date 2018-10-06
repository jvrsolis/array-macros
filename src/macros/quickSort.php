<?php

use Illuminate\Support\Arr;

Arr::macro('quickSort', function ($my_array) {
    $loe = $gt = array();
    if (count($my_array) < 2) {
        return $my_array;
    }
    $pivot_key = key($my_array);
    $pivot = array_shift($my_array);
    foreach ($my_array as $val) {
        if ($val <= $pivot) {
            $loe[] = $val;
        } elseif ($val > $pivot) {
            $gt[] = $val;
        }
    }
    return array_merge(Arr::quickSort($loe), array($pivot_key => $pivot), Arr::quickSort($gt));
});