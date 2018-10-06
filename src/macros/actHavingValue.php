<?php

use Illuminate\Support\Arr;

/**
 * Pass the collection to the given callback and return the result.
 *
 * @param  callable $callback
 * @return mixed
 */
Arr::macro('actHavingValue', function (array $items, $operator, $value, $operate = null) {
    if (func_num_args() === 3) {
        $value = $operator;
        $operator = '=';
    }

    $compare = Arr::operatorForHaving(null, $operator, $value); // Get value from key, check value against needle;

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