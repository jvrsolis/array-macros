<?php

use Illuminate\Support\Arr;

/**
 * Concatenate values of a given key as a string
 * in a multidimensional array.
 *
 * @param  string  $value
 * @param  string  $glue
 * @return string
 */
Arr::macro('implodeMulti', function ($array, $glue = null) {
    $ret = '';

    foreach ($array as $item) {
        if (is_array($item)) {
            $ret .= Arr::implodeMulti($item, $glue) . $glue;
        } else {
            $ret .= $item . $glue;
        }
    }

    $ret = substr($ret, 0, 0 - strlen($glue));

    return $ret;
});