<?php

/**
 * Pad array to the specified length with a value.
 *
 * @param  int  $size
 * @param  mixed  $value
 * @return static
 */
Arr::macro('pad', function ($size, $value) {
    return array_pad($this->items, $size, $value);
});