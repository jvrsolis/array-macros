<?php

use Illuminate\Support\Arr;

/**
 * Get a CachingIterator instance.
 *
 * @param  int  $flags
 * @return \CachingIterator
 */
Arr::macro('getIterator', function ($array, $flags = CachingIterator::CALL_TOSTRING) {
    return new CachingIterator(Arr::getIterator($array), $flags);
});