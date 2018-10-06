<?php

use Illuminate\Support\Arr;

/**
 * Pass the collection to the given callback and return the result.
 *
 * @param  callable $callback
 * @return mixed
 */
Arr::macro('pipes', function (array $array, array $pipes, string $method = 'handle') {
    return app(Pipeline::class)
        ->send($array)
        ->through($pipes)
        ->via($method)
        ->then(function ($content) {
            return $content;
        });
});