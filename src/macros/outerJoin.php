<?php

use Illuminate\Support\Arr;

/**
 * Outer join the given arrays.
 *
 * @param  array  ...$arrays
 * @return array
 */
Arr::macro('outerJoin', function (array $left, array $right, $left_join_on, $right_join_on = null) {
    $final = array();

    if (empty($right_join_on)) {
        $right_join_on = $left_join_on;
    }

    foreach ($left as $k => $v) {
        $final[$k] = $v;
        foreach ($right as $kk => $vv) {
            if ($v[$left_join_on] == $vv[$right_join_on]) {
                foreach ($vv as $key => $val) {
                    $final[$k][$key] = $val;
                }
            } else {
                foreach ($vv as $key => $val) {
                    $final[$k][$key] = null;
                }
            }
        }
    }
    return $final;
});