<?php

use Illuminate\Support\Arr;

/**
 * Returns all possible permutations of $values containing $n elements using a
 * "draw and place back" algorithm
 *
 * The resulting array will always have pow(count($values), $n) entries.
 *
 * For
 *   $values = array('a', 'b') and $n = 2,
 * the result will contain:
 *   [aa, ab, ba, bb]
 *
 * @param array $values Vector to generate permutations of
 * @param int $n Elements per permutation
 * @return array Possible permutations
 */
Arr::macro('permutatations', function ($values, $n) {
    $rec = function (array $values, &$ret, $n, array $cur = array()) use (&$rec) {
        if ($n > 0) {
            foreach ($values as $v) {
                $newCur = $cur;
                $newCur[] = $v;
                $rec($values, $ret, $n - 1, $newCur);
            }
        } else {
            $ret[] = $cur;
        }
    };

    $ret = array();
    $rec($values, $ret, $n);

    return $ret;
});