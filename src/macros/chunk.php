<?php

use Illuminate\Support\Arr;

/**
 * Chunk the array.
 *
 * @param  int  $size
 * @return static
 */
Arr::macro('chunk', function ($array, $size) {
    if ($size <= 0) {
        return [];
    }

    $chunks = [];

    foreach (array_chunk($array, $size, true) as $chunk) {
        $chunks[] = $chunk;
    }

    return $chunks;
});