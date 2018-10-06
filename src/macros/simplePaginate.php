<?php

use Illuminate\Support\Arr;

/**
 * Paginate the array into a simple paginator
 *
 * @param int $perPage
 * @param int $page
 * @param string $pageName
 *
 * @return \Illuminate\Contracts\Pagination\Paginator
 */
Arr::macro('simplePaginate', function ($array, int $perPage = 15, string $pageName = 'page', int $page = null, array $options = []) {
    $page = $page ? : Paginator::resolveCurrentPage($pageName);
    $sliced = Arr::slice($array, ($page - 1) * $perPage);
    $results = Arr::take($array, $sliced, $perPage + 1);
    $options += [
        'path' => Paginator::resolveCurrentPath(),
        'pageName' => $pageName,
    ];
    return new Paginator($results, $perPage, $page, $options);
});