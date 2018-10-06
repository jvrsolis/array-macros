<?php

/**
 * Get the median of a given key.
 *
 * @param  null $key
 * @return mixed
 */
Arr::macro('median', function (array $array, $key = null) {
    $count = Arr::count($array);

    if ($count == 0) {
        return;
    }

    $sorted = with(isset($key) ? Arr::pluck($array, $key) : $array)
        ->sort($array);

    $values = Arr::values($array);

    $middle = (int)($count / 2);

    if ($count % 2) {
        return Arr::get($array, $values, $middle);
    }

    return Arr::average([
        Arr::get($array, $values, $middle - 1), Arr::get($array, $values, $middle),
    ]);
});