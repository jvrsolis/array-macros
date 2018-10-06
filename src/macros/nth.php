<?php

use Illuminate\Support\Arr;

/**
 * Create a new array consisting of every n-th element.
 *
 * @param  int  $step
 * @param  int  $offset
 * @return static
 */
Arr::macro('nth', function ($array, $step, $offset = 0) {
    $new = [];

    $position = 0;

    foreach ($array as $item) {
        if ($position % $step === $offset) {
            $new[] = $item;
        }

        $position++;
    }

    return $new;
});