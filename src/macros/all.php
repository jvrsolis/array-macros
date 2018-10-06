<?php

use Illuminate\Support\Arr;

/**
 * Create a new array instance if the value isn't one already.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('all', function ($array) {
    return (array)$array;
});