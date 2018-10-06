<?php

use Illuminate\Support\Arr;

/**
 * Create a new array instance with a range of numbers. `range`
 * accepts the same parameters as PHP's standard `range` function.
 *
 * @see range
 *
 * @param mixed $start
 * @param mixed $end
 * @param int|float $step
 *
 * @return \Illuminate\Support\Collection
 */
Arr::macro('range', function ($start, $end, $step = 1) {
    return range($start, $end, $step);
});