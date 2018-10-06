<?php

use Illuminate\Support\Arr;

/**
 * "Paginate" the array by slicing it into a smaller array.
 *
 * @param  int  $page
 * @param  int  $perPage
 * @return static
 */
Arr::macro('forPage', function ($array, $page, $perPage) {
    return Arr::slice($array, ($page - 1) * $perPage, $perPage);
});