<?php

use Illuminate\Support\Arr;

Arr::macro('combSort', function ($my_array) {
    $gap = count($my_array);
    $swap = true;
    while ($gap > 1 || $swap) {
        if ($gap > 1) {
            $gap /= 1.25;
        }

        $swap = false;
        $i = 0;
        while ($i + $gap < count($my_array)) {
            if ($my_array[$i] > $my_array[$i + $gap]) {
                list($my_array[$i], $my_array[$i + $gap]) = array($my_array[$i + $gap], $my_array[$i]);
                $swap = true;
            }
            $i++;
        }
    }
    return $my_array;
});