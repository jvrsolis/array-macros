<?php

use Illuminate\Support\Arr;

/**
 * Convert the object into something JSON serializable.
 *
 * @return array
 */
Arr::macro('jsonSerialize', function ($array) {
    return array_map(function ($value) {
        if ($value instanceof JsonSerializable) {
            return $value->jsonSerialize();
        } elseif ($value instanceof Jsonable) {
            return json_decode($value->toJson(), true);
        } elseif ($value instanceof Arrayable) {
            return $value->toArray();
        } else {
            return $value;
        }
    }, $array);
});