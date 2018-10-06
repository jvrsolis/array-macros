<?php

namespace JvrSolis\ArrayMacros;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

use Illuminate\Support\ServiceProvider;

/**
 * Class ArrayMacroServiceProvider
 *
 * A service provider level class
 * used to introduce \Illuminate\Support\Arr
 * macros.
 *
 * @package JvrSolis\ArrayMacros
 */
class ArrayMacroServiceProvider extends ServiceProvider
{
    /**
     * Register the array macros.
     *
     * @return void
     */
    public function register()
    {
        Collection::make(glob(__DIR__ . '/macros/*.php'))
            ->mapWithKeys(function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            })
            ->reject(function ($macro) {
                return Arr::hasMacro($macro);
            })
            ->each(function ($macro, $path) {
                require_once $path;
            });
    }
}