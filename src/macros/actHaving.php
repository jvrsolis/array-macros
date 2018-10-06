<?php

use Illuminate\Support\Arr;

/**
 * Pass the collection to the given callback and return the result.
 *
 * @param  callable $callback
 * @return mixed
 */
Arr::macro('actHaving', function (array $items, $key, $operator, $value = null, $operate = null) {
    if (func_num_args() === 4) {
        $operate = $value;
        $value = $operator;
        $operator = '=';
    }

    $compare = Arr::operatorForHaving($key, $operator, $value); // Get value from key, check value against needle;

    $result = [];

    foreach ($items as $key => $item) {
        if ($compare($item, $key)) {
            if (is_null($operate)) {
                $result[$key] = $item;
                continue;
            }

            $result[$key] = $operate($item, $key);
        }
    }

    return $result;
});