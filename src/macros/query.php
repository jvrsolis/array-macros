<?php

use Illuminate\Support\Arr;

/**
 * Convert the array into a query string.
 *
 * @param  array  $array
 * @return string
 */
Arr::macro('query', function (array $array) {
    return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
});