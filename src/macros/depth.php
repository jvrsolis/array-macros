<?php

use Illuminate\Support\Arr;

/**
 * Return the depth of the array.
 */
Arr::macro('depth', function ($array) {
    $max_depth = 1;

    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = Arr::depth($value) + 1;

            if ($depth > $max_depth) {
                $max_depth = $depth;
            }
        }
    }

    return $max_depth;
});