<?php

use Illuminate\Support\Arr;

/**
 * Create a new array instance if the value isn't one already.
 *
 * @param  mixed  $items
 * @return static
 */
Arr::macro('make', function ($item) {
    return (array)$item;
});