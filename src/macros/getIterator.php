<?php

use Illuminate\Support\Arr;

/**
 * Get an iterator for the items.
 *
 * @return \ArrayIterator
 */
Arr::macro('getIterator', function () {
    return new ArrayIterator($this->items);
});