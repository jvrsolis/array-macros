<?php

use Illuminate\Support\Arr;

/**
 * Get the array of items as JSON.
 *
 * @param  int  $options
 * @return string
 */
Arr::macro('json', function ($array, $options = 0) {
    return json_encode(Arr::jsonSerialize($array), $options);
});