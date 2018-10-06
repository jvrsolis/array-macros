<?php

use Illuminate\Support\Arr;

Arr::macro('gnomeSort', function ($my_array) {
    $i = 1;
    $j = 2;
    while ($i < count($my_array)) {
        if ($my_array[$i - 1] <= $my_array[$i]) {
            $i = $j;
            $j++;
        } else {
            list($my_array[$i], $my_array[$i - 1]) = array($my_array[$i - 1], $my_array[$i]);
            $i--;
            if ($i == 0) {
                $i = $j;
                $j++;
            }
        }
    }
    return $my_array;
});