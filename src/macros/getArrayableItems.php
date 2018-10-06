<?php

use Illuminate\Support\Arr;

/**
 * Results array of items from array or Arrayable.
 *
 * @param  mixed  $items
 * @return array
 */
Arr::macro('getArrayableItems', function ($items) {
    if (is_array($items)) {
        return $items;
    } elseif ($items instanceof Collection) {
        return $items->all();
    } elseif ($items instanceof Arrayable) {
        return $items->array();
    } elseif ($items instanceof Jsonable) {
        return json_decode($items->toJson(), true);
    } elseif ($items instanceof JsonSerializable) {
        return $items->jsonSerialize();
    } elseif ($items instanceof Traversable) {
        return iterator_to_array($items);
    }

    return (array)$items;
});