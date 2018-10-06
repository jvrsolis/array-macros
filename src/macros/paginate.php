<?php

use Illuminate\Support\Arr;

/**
 * Paginate the given array
 *
 * @param int $perPage
 * @param int $total
 * @param int $page
 * @param string $pageName
 *
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
Arr::macro('paginate', function ($array, int $perPage = 15, string $pageName = 'page', int $page = null, int $total = null, array $options = []) {
    $page = $page ? : LengthAwarePaginator::resolveCurrentPage($pageName);
    $results = Arr::forPage($array, $page, $perPage);
    $total = $total ? : Arr::count($array);
    $options += [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
        'pageName' => $pageName,
    ];
    return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
});