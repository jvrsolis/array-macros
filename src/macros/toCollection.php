<?php

use Illuminate\Support\Arr;

if (!Arr::hasMacro('toCollection')) {
    /*
     * Dump the contents of the array and terminate the script.
     */
    Arr::macro('toCollection', function ($array) {
        return collect($array);
    });
}