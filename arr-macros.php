<?php
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

if (!Arr::hasMacro('search')) {
    /**
     * Search the array for a given value and return the corresponding key if successful.
     *
     * @param  mixed  $value
     * @param  bool  $strict
     * @return mixed
     */
    Arr::macro('search', function (array $array, $value, $strict = false) {
        if (!static::useAsCallable($value)) {
            return array_search($value, $array, $strict);
        }

        foreach ($array as $key => $item) {
            if (call_user_func($value, $item, $key)) {
                return $key;
            }
        }

        return false;
    });
}

if (!Arr::hasMacro('searchRobust')) {
    /**
     * Get all keys from a variable dimensional array
     * for a given value.
     *
     * @param  array          $haystack  The array to search through
     * @param  string|array   $needle    The value(s) to search for.
     * @param  int|array      $ith       The $ith(s) item(s) the user should retrive from the final result.
     * @param  int|array      $nth       The nth(s) occurance(s) of the value within a nested array to obtain.
     * @param  int|array      $depth     The depth(s) at which to obtain the value(s.
     * @param  int            $level     The current level the function is at.
     * @param  string         $notation  The dot notation key where the values were found.
     * @return mixed                     An array of dot notation keys containing the results looked for.
     */
    Arr::macro('searchRobust', function ($haystack, $needle, $ith = null, $nth = null, $depth = null, $level = 0, $notation = '') {
        $level += 1;
        $count = 1;
        $length = 0;
        $output = [];
        $maxLength = is_array($nth) ? count($nth) : $nth;
        $maxIteration = is_array($nth) ? max($nth) : $nth;
        $depthRange = is_array($depth) ? range(max($depth), min($depth)) : null;

        if (is_null($depth) || (is_numeric($depth) && $level <= $depth) || (is_array($depth) && in_array($depthRange, $level))) {
            if (is_array($haystack) && count($haystack) > 0) {
                foreach ($haystack as $key => $value) {
                    if ($value == $needle) {
                        if ($notation != '') {
                            if (is_null($depth) || (is_numeric($depth) && ($level == $depth)) || (is_array($depth) && in_array($depth, $level))) {
                                array_push($output, $notation . "." . $key);
                            }
                        } else {
                            if (is_null($depth) || (is_numeric($depth) && ($level == $depth)) || (is_array($depth) && in_array($depth, $level))) {
                                array_push($output, $key);
                            }
                        }
                        $count++;
                    } elseif (is_array($value)) {
                        list($result, $atDepth) = static::searchRobust($value, $needle, $ith, $nth, $depth, $level, $key);

                        if (!empty($result) && $result != $output) {
                            if (is_null($depth) || (is_numeric($depth) && ($atDepth == $depth)) || (is_array($depth) && in_array($depth, $atDepth))) {
                                array_push($output, ...$result);
                            }

                            $count++;
                        }
                    }

                    $length = !empty($output) ? count($output) : 0;

                    if (!is_null($nth) && ($length >= $maxLength || $count - 1 == $maxIteration)) {
                        break;
                    }
                }
            }
        }

        if ($level == 1) {
            if (empty($output)) {
                return $output;
            } elseif (is_array($ith)) {
                $final = [];

                foreach ($ith as $instance) {
                    if (isset($output[$instance - 1])) {
                        $final[] = $output[$instance - 1];
                    }
                }

                return $final;
            } else {
                return !is_null($ith) && isset($output[$ith - 1]) ? $output[$ith - 1] : $output;
            }
        } else {
            $level = isset($atDepth) ? $atDepth : $level;
            return [$output, $level];
        }
    });
}

if (!Arr::hasMacro('whereOperation')) {
    /**
     * Filter items by the given key value pair.
     *
     * @param  string  $key
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return static
     */
    Arr::macro('whereOperation', function (array $array, $key, $operator, $value = null) {
        if (func_num_args() == 3) {
            $value = $operator;

            $operator = '=';
        }

        return static::filter($array, static::operatorForWhere($key, $operator, $value));
    });
}

if (!Arr::hasMacro('whereStrict')) {
    /**
     * Filter items by the given key value pair using strict comparison.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return static
     */
    Arr::macro('whereStrict', function (array $array, $key, $value) {
        return static::whereOperation($array, $key, '===', $value);
    });
}

if (!Arr::hasMacro('whereIn')) {
    /**
     * Filter items by the given key value pair.
     *
     * @param  string  $key
     * @param  mixed  $values
     * @param  bool  $strict
     * @return static
     */
    Arr::macro('whereIn', function (array $array, $key, $values, $strict = false) {
        $values = static::getArrayableItems($values);

        return static::filter($array, function ($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    });
}

if (!Arr::hasMacro('whereInStrict')) {
    /**
     * Filter items by the given key value pair using strict comparison.
     *
     * @param  string  $key
     * @param  mixed  $values
     * @return array
     */
    Arr::macro('whereInStrict', function (array $array, $key, $value) {
        return static::whereIn($array, $key, $values, true);
    });
}

if (!Arr::hasMacro('whereNotIn')) {
    /**
     * Filter items by the given key value pair.
     *
     * @param  string  $key
     * @param  mixed  $values
     * @param  bool  $strict
     * @return array
     */
    Arr::macro('whereNotIn', function (array $array, $key, $values, $strict = false) {
        $values = static::getArrayableItems($values);

        return static::reject($array, function ($item) use ($key, $values, $strict) {
            return in_array(data_get($item, $key), $values, $strict);
        });
    });
}

if (!Arr::hasMacro('whereNotInStrict')) {
    /**
     * Filter items by the given key value pair using strict comparison.
     *
     * @param  string  $key
     * @param  mixed  $values
     * @return array
     */
    Arr::macro('whereNotInStrict', function (array $array, $key, $values) {
        return static::whereNotIn($array, $key, $values, true);
    });
}

if (!Arr::hasMacro('filter')) {
    /**
     * Run a filter over each of the items.
     *
     * @param  callable|null  $callback
     * @return static
     */
    Arr::macro('filter', function (array $array, callable $callback = null) {
        if ($callback) {
            return static::where($array, $callback);
        }

        return array_filter($array);
    });
}

if (!Arr::hasMacro('unique')) {
    /**
     * Return only unique items from the array array.
     *
     * @param  string|callable|null  $key
     * @param  bool  $strict
     * @return static
     */
    Arr::macro('unique', function (array $array, $key = null, $strict = false) {
        if (is_null($key)) {
            return array_unique($array, SORT_REGULAR);
        }

        $callback = static::valueRetriever($key);

        $exists = [];

        return static::reject($array, function ($item, $key) use ($callback, $strict, &$exists) {
            if (in_array($id = $callback($item, $key), $exists, $strict)) {
                return true;
            }

            $exists[] = $id;
        });
    });
}

if (!Arr::hasMacro('uniqueStrict')) {
    /**
     * Return only unique items from the array array using strict comparison.
     *
     * @param  string|callable|null  $key
     * @return static
     */
    Arr::macro('uniqueStrict', function (array $array) {
        return static::unique($array, $key, true);
    });
}

if (!Arr::hasMacro('reject')) {
    /**
     * Create a array of all elements that do not pass a given truth test.
     *
     * @param  callable|mixed  $callback
     * @return static
     */
    Arr::macro('reject', function (array $array, $callback) {
        if (static::useAsCallable($callback)) {
            return static::filter(function ($value, $key) use ($callback) {
                return !$callback($value, $key);
            });
        }

        return static::filter($array, function ($item) use ($callback) {
            return $item != $callback;
        });
    });
}

if (!Arr::hasMacro('except')) {
    Arr::macro('except', function ($array, $keys) {
        static::forget($array, $keys);

        return $array;
    });
}

if (!Arr::hasMacro('exceptNull')) {
    Arr::macro('exceptNull', function (array $array) {
        $filtered = static::filter($array, function ($item) {
            return !is_null($item);
        });

        return static::values($filtered);
    });
}

if (!Arr::hasMacro('exceptEmpty')) {
    Arr::macro('exceptEmpty', function (array $array) {
        $filtered = static::filter($array, function ($item) {
            return !empty($item);
        });

        return static::values($filtered);
    });
}

if (!Arr::hasMacro('only')) {
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    Arr::macro('only', function (array $array, $keys) {
        return array_intersect_key($array, array_flip((array) $keys));
    });
}

if (!Arr::hasMacro('sort')) {
    /**
     * Sort through each item with a callback.
     *
     * @param  callable|null  $callback
     * @return static
     */
    Arr::macro('sort', function (array $array, callable $callback = null) {
        $items = $array;

        $callback
        ? uasort($items, $callback)
        : asort($items);

        return $items;
    });
}

if (!Arr::hasMacro('sortMulti')) {
    /**
     * Sort a multidimensional array by keys and values.
     *
     * @param  array  $array
     * @return array
     */
    Arr::macro('sortMulti', function (array $array) {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = static::sortMulti($value);
            }
        }

        if (static::isAssoc($array)) {
            ksort($array);
        } else {
            sort($array);
        }

        return $array;
    });
}

if (!Arr::hasMacro('sortBy')) {
    /**
     * Sort the array using the given callback.
     *
     * @param  callable|string  $callback
     * @param  int  $options
     * @param  bool  $descending
     * @return static
     */
    Arr::macro('sortBy', function (array $array, $callback, $options = SORT_REGULAR, $descending = false) {
        $results = [];

        $callback = static::valueRetriever($callback);

        // First we will loop through the items and get the comparator from a callback
        // function which we were given. Then, we will sort the returned values and
        // and grab the corresponding values for the sorted keys from this array.
        foreach ($array as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        $descending ? arsort($results, $options)
        : asort($results, $options);

        // Once we have sorted all of the keys in the array, we will loop through them
        // and grab the corresponding model so we can set the items list
        // to the sorted version. Then we'll just return the array instance.
        foreach (array_keys($results) as $key) {
            $results[$key] = $array[$key];
        }

        return $results;
    });
}

if (!Arr::hasMacro('sortByDesc')) {
    /**
     * Sort the array in descending order using the given callback.
     *
     * @param  callable|string  $callback
     * @param  int  $options
     * @return static
     */
    Arr::macro('sortByDesc', function (array $array, $callback, $options = SORT_REGULAR) {
        return static::sortBy($array, $callback, $options, true);
    });
}

if (!Arr::hasMacro('sortByMany')) {
    /**
     * An extension of the {@see Arr::sortBy()} method that allows for sorting against as many different
     * keys. Uses a combination of {@see Arr::sortBy()} and {@see Arr::groupBy()} to achieve this.
     *
     * @param array $keys An associative array that uses the key to sort by (which accepts dot separated values,
     *                    as {@see Arr::sortBy()} would) and the value is the order (either ASC or DESC)
     */
    Arr::macro('sortByMany', function (array $array, array $keys) {
        $currentIndex = 0;
        $keys = array_map(function ($key, $sort) {
            return ['key' => $key, 'sort' => $sort];
        }, array_keys($keys), $keys);

        $sortBy = function (array $collection) use (&$currentIndex, $keys, &$sortBy) {
            if ($currentIndex >= count($keys)) {
                return $collection;
            }

            $key = $keys[$currentIndex]['key'];
            $sort = $keys[$currentIndex]['sort'];
            $sortFunc = $sort === 'DESC' ? 'sortByDesc' : 'sortBy';
            $currentIndex++;
            $sorted = static::$sortFunc($collection, $key);
            $grouped = static::groupBy($sorted, $key);

            $mapped = static::map($grouped, $sortBy);

            $ungrouped = static::ungroup($mapped);

            return $ungrouped;
        };

        return $sortBy($array);
    });
}

if (!Arr::hasMacro('mergeSort')) {
    Arr::macro('mergeSort', function ($data) {
        // Only process if we're not down to one piece of data
        if (count($data) > 1) {
            // Find out the middle of the current data set and split it there to obtain to halfs
            $data_middle = round(count($data) / 2, 0, PHP_ROUND_HALF_DOWN);
            // and now for some recursive magic
            $data_part1 = static::mergeSort(array_slice($data, 0, $data_middle));
            $data_part2 = static::mergeSort(array_slice($data, $data_middle, count($data)));
            // Setup counters so we can remember which piece of data in each half we're looking at
            $counter1 = $counter2 = 0;
            // iterate over all pieces of the currently processed array, compare size & reassemble
            for ($i = 0; $i < count($data); $i++) {
                // if we're done processing one half, take the rest from the 2nd half
                if ($counter1 == count($data_part1)) {
                    $data[$i] = $data_part2[$counter2];
                    ++$counter2;
                    // if we're done with the 2nd half as well or as long as pieces in the first half are still smaller than the 2nd half
                } elseif (($counter2 == count($data_part2)) or ($data_part1[$counter1] < $data_part2[$counter2])) {
                    $data[$i] = $data_part1[$counter1];
                    ++$counter1;
                } else {
                    $data[$i] = $data_part2[$counter2];
                    ++$counter2;
                }
            }
        }
        return $data;
    });
}

if (!Arr::hasMacro('quickSort')) {
    Arr::macro('quickSort', function ($my_array) {
        $loe = $gt = array();
        if (count($my_array) < 2) {
            return $my_array;
        }
        $pivot_key = key($my_array);
        $pivot = array_shift($my_array);
        foreach ($my_array as $val) {
            if ($val <= $pivot) {
                $loe[] = $val;
            } elseif ($val > $pivot) {
                $gt[] = $val;
            }
        }
        return array_merge(static::quickSort($loe), array($pivot_key => $pivot), static::quickSort($gt));
    });
}

if (!Arr::hasMacro('bubbleSort')) {
    Arr::macro('bubbleSort', function ($array) {
        if (!$length = count($array)) {
            return $array;
        }
        for ($outer = 0; $outer < $length; $outer++) {
            for ($inner = 0; $inner < $length; $inner++) {
                if ($array[$outer] < $array[$inner]) {
                    $tmp = $array[$outer];
                    $array[$outer] = $array[$inner];
                    $array[$inner] = $tmp;
                }
            }
        }
    });
}

if (!Arr::hasMacro('bidirectionalBubbleSort')) {
    Arr::macro('bidirectionalBubbleSort', function ($array) {
        if (!$length = count($array)) {
            return $array;
        }
        $start = -1;
        while ($start < $length) {
            ++$start;
            --$length;
            for ($i = $start; $i < $length; ++$i) {
                if ($array[$i] > $array[$i + 1]) {
                    $temp = $array[$i];
                    $array[$i] = $array[$i + 1];
                    $array[$i + 1] = $temp;
                }
            }
            for ($i = $length; --$i >= $start;) {
                if ($array[$i] > $array[$i + 1]) {
                    $temp = $array[$i];
                    $array[$i] = $array[$i + 1];
                    $array[$i + 1] = $temp;
                }
            }
        }
    });
}

if (!Arr::hasMacro('insertionSort')) {
    Arr::macro('insertionSort', function ($my_array) {
        for ($i = 0; $i < count($my_array); $i++) {
            $val = $my_array[$i];
            $j = $i - 1;
            while ($j >= 0 && $my_array[$j] > $val) {
                $my_array[$j + 1] = $my_array[$j];
                $j--;
            }
            $my_array[$j + 1] = $val;
        }
        return $my_array;
    });
}

if (!Arr::hasMacro('selectionSort')) {
    Arr::macro('selectionSort', function ($data) {
        for ($i = 0; $i < count($data) - 1; $i++) {
            $min = $i;
            for ($j = $i + 1; $j < count($data); $j++) {
                if ($data[$j] < $data[$min]) {
                    $min = $j;
                }
            }
            $data = static::swapPositions($data, $i, $min);
        }
        return $data;
    });
}

if (!Arr::hasMacro('shellSort')) {
    Arr::macro('shellSort', function ($my_array) {
        $x = round(count($my_array) / 2);
        while ($x > 0) {
            for ($i = $x; $i < count($my_array); $i++) {
                $temp = $my_array[$i];
                $j = $i;
                while ($j >= $x && $my_array[$j - $x] > $temp) {
                    $my_array[$j] = $my_array[$j - $x];
                    $j -= $x;
                }
                $my_array[$j] = $temp;
            }
            $x = round($x / 2.2);
        }
        return $my_array;
    });
}

if (!Arr::hasMacro('cocktailSort')) {
    Arr::macro('cocktailSort', function ($my_array) {
        if (is_string($my_array)) {
            $my_array = str_split(preg_replace('/\s+/', '', $my_array));
        }

        do {
            $swapped = false;
            for ($i = 0; $i < count($my_array); $i++) {
                if (isset($my_array[$i + 1])) {
                    if ($my_array[$i] > $my_array[$i + 1]) {
                        list($my_array[$i], $my_array[$i + 1]) = array($my_array[$i + 1], $my_array[$i]);
                        $swapped = true;
                    }
                }
            }

            if ($swapped == false) {
                break;
            }

            $swapped = false;
            for ($i = count($my_array) - 1; $i >= 0; $i--) {
                if (isset($my_array[$i - 1])) {
                    if ($my_array[$i] < $my_array[$i - 1]) {
                        list($my_array[$i], $my_array[$i - 1]) = array($my_array[$i - 1], $my_array[$i]);
                        $swapped = true;
                    }
                }
            }
        } while ($swapped);

        return $my_array;
    });
}

if (!Arr::hasMacro('combSort')) {
    Arr::macro('combSort', function ($my_array) {
        $gap = count($my_array);
        $swap = true;
        while ($gap > 1 || $swap) {
            if ($gap > 1) {
                $gap /= 1.25;
            }

            $swap = false;
            $i = 0;
            while ($i + $gap < count($my_array)) {
                if ($my_array[$i] > $my_array[$i + $gap]) {
                    list($my_array[$i], $my_array[$i + $gap]) = array($my_array[$i + $gap], $my_array[$i]);
                    $swap = true;
                }
                $i++;
            }
        }
        return $my_array;
    });
}

if (!Arr::hasMacro('gnomeSort')) {
    Arr::macro('gnomeSort', function ($my_array) {
        $i = 1;
        $j = 2;
        while ($i < count($my_array)) {
            if ($my_array[$i - 1] <= $my_array[$i]) {
                $i = $j;
                $j++;
            } else {
                list($my_array[$i], $my_array[$i - 1]) = array($my_array[$i - 1], $my_array[$i]);
                $i--;
                if ($i == 0) {
                    $i = $j;
                    $j++;
                }
            }
        }
        return $my_array;
    });
}

if (!Arr::hasMacro('countingSort')) {
    Arr::macro('countingSort', function ($my_array) {
        $count = array();
        for ($i = $min; $i <= $max; $i++) {
            $count[$i] = 0;
        }

        foreach ($my_array as $number) {
            $count[$number]++;
        }
        $z = 0;
        for ($i = $min; $i <= $max; $i++) {
            while ($count[$i]-- > 0) {
                $my_array[$z++] = $i;
            }
        }
        return $my_array;
    });
}

if (!Arr::hasMacro('radixSort')) {
    Arr::macro('radixSort', function ($elements) {
        // Array for 10 queues.
        $queues = array(
            array(), array(), array(), array(), array(), array(), array(), array(),
            array(), array(),
        );
        // Queues are allocated dynamically. In first iteration longest digits
        // element also determined.
        $longest = 0;
        foreach ($elements as $el) {
            if ($el > $longest) {
                $longest = $el;
            }
            array_push($queues[$el % 10], $el);
        }
        // Queues are dequeued back into original elements.
        $i = 0;
        foreach ($queues as $key => $q) {
            while (!empty($queues[$key])) {
                $elements[$i++] = array_shift($queues[$key]);
            }
        }
        // Remaining iterations are determined based on longest digits element.
        $it = strlen($longest) - 1;
        $d = 10;
        while ($it--) {
            foreach ($elements as $el) {
                array_push($queues[floor($el / $d) % 10], $el);
            }
            $i = 0;
            foreach ($queues as $key => $q) {
                while (!empty($queues[$key])) {
                    $elements[$i++] = array_shift($queues[$key]);
                }
            }
            $d *= 10;
        }
    });
}

if (!Arr::hasMacro('beadSort')) {
    Arr::macro('beadSort', function ($my_array) {
        $sortColumns = function ($my_array) {
            if (count($my_array) == 0) {
                return array();
            } elseif (count($my_array) == 1) {
                return array_chunk($my_array[0], 1);
            }

            array_unshift($my_array, null);
            // array_map(NULL, $my_array[0], $my_array[1], ...)
            $transpose = call_user_func_array('array_map', $my_array);
            return array_map('array_filter', $transpose);
        };

        foreach ($my_array as $e) {
            $poles[] = array_fill(0, $e, 1);
        }

        return array_map('count', $sortColumns($sortColumns($poles)));
    });
}

if (!Arr::hasMacro('bogoSort')) {
    Arr::macro('bogoSort', function ($list) {
        $isSorted = function ($list) {
            $cnt = count($list);
            for ($j = 1; $j < $cnt; $j++) {
                if ($list[$j - 1] > $list[$j]) {
                    return false;
                }
            }
            return true;
        };

        do {
            shuffle($list);
        } while (!$isSorted($list));
        return $list;
    });
}

if (!Arr::hasMacro('checkSort')) {
    Arr::macro('checkSort', function () {
        if (!$length = count($array)) {
            return true;
        }
        for ($i = 0; $i < $length; $i++) {
            if (isset($array[$i + 1])) {
                if ($array[$i] > $array[$i + 1]) {
                    return false;
                }
            }
        }
        return true;
    });
}

if (!Arr::hasMacro('groupBy')) {
    /**
     * Group an associative array by a field or using a callback.
     *
     * @param  callable|string  $groupBy
     * @param  bool  $preserveKeys
     * @return static
     */
    Arr::macro('groupBy', function (array $array, $groupBy, $preserveKeys = false) {
        $groupBy = static::valueRetriever($groupBy);
        $results = [];

        foreach ($array as $key => $value) {
            $groupKeys = $groupBy($value, $key);

            if (!is_array($groupKeys)) {
                $groupKeys = [$groupKeys];
            }

            foreach ($groupKeys as $groupKey) {
                $groupKey = is_bool($groupKey) ? (int) $groupKey : $groupKey;
                if (!array_key_exists($groupKey, $results)) {
                    $results[$groupKey] = [];
                }

                $results[$groupKey] = static::offsetSet($results[$groupKey], $preserveKeys ? $key : null, $value);
            }
        }

        return $results;
    });
}

if (!Arr::hasMacro('groupByMany')) {
    /**
     * Group an associative array by multiple fields or callbacks.
     *
     * @param  string|array  $groupBy
     * @param  bool  $preserveKeys
     * @return Collection
     */
    Arr::macro('groupByMany', function (array $array, $groupBy, $preserveKeys = false) {
        if (!is_array($groupBy)) {
            $groupBy = [$groupBy];
        }
        $groupKeyRetrievers = [];
        foreach ($groupBy as $currentGroupBy) {
            $groupKeyRetrievers[] = static::valueRetriever($currentGroupBy);
        }
        $results = [];
        foreach ($array as $key => $value) {
            $currentLevel = [ & $results];
            $nextLevel = [];
            foreach ($groupKeyRetrievers as $currentGroupBy) {
                $groupKeys = $currentGroupBy($value);
                if (!is_array($groupKeys)) {
                    $groupKeys = [$groupKeys];
                }
                foreach ($groupKeys as $groupKey) {
                    foreach ($currentLevel as &$subGroup) {
                        if (!array_key_exists($groupKey, $subGroup)) {
                            $subGroup[$groupKey] = [];
                        }
                        $nextLevel[] = &$subGroup[$groupKey];
                    }
                }
                $currentLevel = $nextLevel;
                $nextLevel = [];
            }
            if ($preserveKeys && !is_null($key)) {
                foreach ($currentLevel as &$lastLevel) {
                    $lastLevel[$key] = $value;
                }
            } else {
                foreach ($currentLevel as &$lastLevel) {
                    $lastLevel[] = $value;
                }
            }
        }
        $toNestedCollection = function (&$array) use (&$toNestedCollection) {
            if (is_array($array)) {
                foreach ($array as &$subArray) {
                    $subArray = $toNestedCollection($subArray);
                }
                return $array;
            } else {
                return $array;
            }
        };
        return $toNestedCollection($results);
    });
}

if (!Arr::hasMacro('ungroup')) {
    /**
     * Ungroup a previously grouped array (grouped by {@see Arr::groupBy()})
     */
    Arr::macro('ungroup', function (array $array) {
        // create a new array to use as the array where the other arrays are merged into
        $newCollection = static::make([]);

        Arr::each($array, function ($item) use (&$newCollection) {
            // use merge to combine the arrays
            $newCollection = static::merge($newCollection, $item);
        });

        return $newCollection;
    });
}

if (!Arr::hasMacro('avg')) {
    /**
     * Get the average value of a given key.
     *
     * @param  callable|string|null  $callback
     * @return mixed
     */
    Arr::macro('avg', function (array $array, $callback = null) {
        if ($count = static::count($array)) {
            return static::sum($array, $callback) / $count;
        }
    });
}

if (!Arr::hasMacro('average')) {
    /**
     * Alias for the "avg" method.
     *
     * @param  callable|string|null  $callback
     * @return mixed
     */
    Arr::macro('average', function (array $array, $callback = null) {
        return static::avg($array, $callback);
    });
}

if (!Arr::hasMacro('count')) {
    /**
     * Count the number of items in the array.
     *
     * @var    array
     * @return int
     */
    Arr::macro('count', function (array $array) {
        return count($array);
    });
}

if (!Arr::hasMacro('sum')) {
    /**
     * Get the sum of the given values.
     *
     * @param  callable|string|null  $callback
     * @return mixed
     */
    Arr::macro('sum', function (array $array, $callback = null) {
        if (is_null($callback)) {
            return array_sum($array);
        }

        $callback = static::valueRetriever($callback);

        return static::reduce($array, function ($result, $item) use ($callback) {
            return $result + $callback($item);
        }, 0);
    });
}

if (!Arr::hasMacro('max')) {
    /**
     * Get the max value of a given key.
     *
     * @param  callable|string|null  $callback
     * @return mixed
     */
    Arr::macro('max', function (array $array, $callback = null) {
        $callback = static::valueRetriever($callback);

        $filter = static::filter(function ($value) {
            return !is_null($value);
        });

        return static::reduce($filter, function ($result, $item) use ($callback) {
            $value = $callback($item);

            return is_null($result) || $value > $result ? $value : $result;
        });
    });
}

if (!Arr::hasMacro('min')) {
    /**
     * Get the min value of a given key.
     *
     * @param  callable|string|null  $callback
     * @return mixed
     */
    Arr::macro('min', function (array $array, $callback = null) {
        $callback = static::valueRetriever($callback);

        $filter = static::filter($reduce, function ($value) {
            return !is_null($value);
        });

        return static::reduce($filter, function ($result, $item) use ($callback) {
            $value = $callback($item);
            return is_null($result) || $value < $result ? $value : $result;
        });
    });
}

if (!Arr::hasMacro('mode')) {
    /**
     * Get the mode of a given key.
     *
     * @param  mixed  $key
     * @return array|null
     */
    Arr::macro('mode', function (array $array, $key = null) {
        $count = static::count($array);

        if ($count == 0) {
            return;
        }

        $collection = isset($key) ? static::pluck($array, $key) : [];

        $counts = [];

        static::each($collection, function ($value) use ($counts) {
            $counts[$value] = isset($counts[$value]) ? $counts[$value] + 1 : 1;
        });

        $sorted = static::sort($counts);

        $highestValue = static::last($sorted);

        $filtered = static::filter($sorted, function ($value) use ($highestValue) {
            return $value == $highestValue;
        });

        $sorted = static::sort($filtered);

        $keys = static::keys($sorted);

        return static::all($keys);
    });
}

if (!Arr::hasMacro('median')) {
    /**
     * Get the median of a given key.
     *
     * @param  null $key
     * @return mixed
     */
    Arr::macro('median', function (array $array, $key = null) {
        $count = static::count($array);

        if ($count == 0) {
            return;
        }

        $sorted = with(isset($key) ? static::pluck($array, $key) : $array)
            ->sort($array);

        $values = Arr::values($array);

        $middle = (int) ($count / 2);

        if ($count % 2) {
            return Arr::get($array, $values, $middle);
        }

        return static::average([
            static::get($array, $values, $middle - 1), static::get($array, $values, $middle),
        ]);
    });
}

if (!Arr::hasMacro('range')) {
    /**
     * Create a new array instance with a range of numbers. `range`
     * accepts the same parameters as PHP's standard `range` function.
     *
     * @see range
     *
     * @param mixed $start
     * @param mixed $end
     * @param int|float $step
     *
     * @return \Illuminate\Support\Collection
     */
    Arr::macro('range', function ($start, $end, $step = 1) {
        return range($start, $end, $step);
    });
}

if (!Arr::hasMacro('aggregate')) {
    /**
     * Call an aggregate function on an array.
     *
     * @param array $array
     * @param string $aggregate
     * @return array
     */
    Arr::macro('aggregate', function ($array, $aggregate) {
        if (is_callable($aggregate)) {
            return $aggregate($array);
        }
        if (strtolower($aggregate) == 'sum') {
            return static::sum($array);
        } elseif (strtolower($aggregate) == 'count') {
            return static::count($array);
        } elseif (strtolower($aggregate) == 'max') {
            return static::max($array);
        } elseif (strtolower($aggregate) == 'min') {
            return static::min($array);
        } elseif (strtolower($aggregate) == 'avg') {
            return static::avg($array);
        } else {
            return $array;
        }
    });
}

if (!Arr::hasMacro('tap')) {
    /**
     * Pass the array to the given callback and then return it.
     *
     * @param  callable  $callback
     * @return $array
     */
    Arr::macro('tap', function (array $array, callable $callback) {
        return $callback($array);
    });
}

if (!Arr::hasMacro('when')) {
    /**
     * Apply the callback if the value is truthy.
     *
     * @param  bool  $value
     * @param  callable  $callback
     * @param  callable  $default
     * @return mixed
     */
    Arr::macro('when', function (array $array, bool $value, callable $callback, callable $default = null) {
        if ($value) {
            return $callback($array);
        } elseif ($default) {
            return $default($array);
        }

        return $array;
    });
}

if (!Arr::hasMacro('unless')) {
    /**
     * Apply the callback if the value is falsy.
     *
     * @param  bool  $value
     * @param  callable  $callback
     * @param  callable  $default
     * @return mixed
     */
    Arr::macro('unless', function (array $array, bool $value, callable $callback, callable $default = null) {
        return static::when($array, !$value, $callback, $default);
    });
}

if (!Arr::hasMacro('ifEmpty')) {
    /**
     * Execute a callable if the array is empty, then return the array.
     *
     * @param callable $callback
     *
     * @return \Illuminate\Support\Collection
     */
    Arr::macro('ifEmpty', function ($array, callable $callback) {
        if (static::isEmpty($array)) {
            $callback($array);
        }
        return $array;
    });
}

if (!Arr::hasMacro('ifAny')) {
    /**
     * Execute a callable if the array isn't empty, then return the array.
     *
     * @param callable callback
     * @return \Illuminate\Support\Collection
     */
    Arr::macro('ifAny', function (array $array, callable $callback) {
        if (!static::isEmpty($array)) {
            $callback($array);
        }
        return $array;
    });
}

if (!Arr::hasMacro('map')) {
    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('map', function (array $array, callable $callback) {
        $keys = array_keys($array);

        $items = array_map($callback, $array, $keys);

        return array_combine($keys, $items);
    });
}

if (!Arr::hasMacro('mapWithKeys')) {
    /**
     * Run an associative map over each of the items.
     *
     * The callback should return an associative array with a single key/value pair.
     *
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('mapWithKeys', function (array $array, callable $callback) {
        $result = [];

        foreach ($array as $key => $value) {
            $assoc = $callback($value, $key);

            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }

        return $result;
    });
}

if (!Arr::hasMacro('mapSpread')) {
    /**
     * Run a map over each nested chunk of items.
     *
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('mapSpread', function (array $array, callable $callback) {
        return static::map($array, function ($chunk) use ($callback) {
            return $callback(...$chunk);
        });
    });
}

if (!Arr::hasMacro('mapToGroups')) {
    /**
     * Run a grouping map over the items.
     *
     * The callback should return an associative array with a single key/value pair.
     *
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('mapToGroups', function (array $array, callable $callback) {
        $mapped = static::map($array, $callback);

        $groups = static::reduce($mapped, function ($groups, $pair) {
            $groups[key($pair)][] = reset($pair);
            return $groups;
        }, []);

        return $groups;
    });
}

if (!Arr::hasMacro('mapToAssoc')) {
    Arr::macro('mapToAssoc', function (array $array, $callback) {
        return static::toAssoc(static::map($array, $callback));
    });
}

if (!Arr::hasMacro('flatMap')) {
    /**
     * Map a array and flatten the result by a single level.
     *
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('flatMap', function (array $array, callable $callback) {
        $mapped = static::map($array, $callback);
        return static::collapse($mapped);
    });
}

if (!Arr::hasMacro('pluck')) {
    /**
     * Pluck an array of values from an array.
     *
     * @param  array  $array
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    Arr::macro('pluck', function ($array, $value, $key = null) {
        $results = [];

        list($value, $key) = static::explodePluckParameters($value, $key);

        foreach ($array as $item) {
            $itemValue = data_get($item, $value);

            // If the key is "null", we will just append the value to the array and keep
            // looping. Otherwise we will key the array using the value of the key we
            // received from the developer. Then we'll return the final array form.
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = data_get($item, $key);

                if (is_object($itemKey) && method_exists($itemKey, '__toString')) {
                    $itemKey = (string) $itemKey;
                }

                $results[$itemKey] = $itemValue;
            }
        }

        return $results;
    });
}

if (!Arr::hasMacro('values')) {
    /**
     * Reset the keys on the array.
     *
     * @return static
     */
    Arr::macro('values', function (array $array) {
        return array_values($array);
    });
}

if (!Arr::hasMacro('keys')) {
    /**
     * Get the keys of the array items.
     *
     * @return static
     */
    Arr::macro('keys', function (array $array) {
        return array_keys($array);
    });
}

if (!Arr::hasMacro('keyBy')) {
    /**
     * Key an associative array by a field or using a callback.
     *
     * @param  callable|string  $keyBy
     * @return static
     */
    Arr::macro('keyBy', function (array $array, $keyBy) {
        $keyBy = static::valueRetriever($keyBy);

        $results = [];

        foreach ($array as $key => $item) {
            $resolvedKey = $keyBy($item, $key);

            if (is_object($resolvedKey)) {
                $resolvedKey = (string) $resolvedKey;
            }

            $results[$resolvedKey] = $item;
        }

        return $results;
    });
}

if (!Arr::hasMacro('times')) {
    /**
     * Create a new array by invoking the callback a given number of times.
     *
     * @param  int  $number
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('times', function (array $array, int $number, callable $callback = null) {
        if ($number < 1) {
            return [];
        }

        if (is_null($callback)) {
            return range(1, $number);
        }

        return static::map(range(1, $number), $callback);
    });
}

if (!Arr::hasMacro('each')) {
    /**
     * Execute a callback over each item.
     *
     * @param  callable  $callback
     * @return $array
     */
    Arr::macro('each', function (array $array, callable $callback) {
        foreach ($array as $key => $item) {
            $array[$key] = $callback($item, $key);
        }
        return $array;
    });
}

if (!Arr::hasMacro('eachSpread')) {
    /**
     * Execute a callback over each nested chunk of items.
     *
     * @param  callable  $callback
     * @return static
     */
    Arr::macro('eachSpread', function (array $array, callable $callback) {
        return static::each($array, function ($chunk) use ($callback) {
            return $callback(...$chunk);
        });
    });
}

if (!Arr::hasMacro('first')) {
    Arr::macro('first', function (array $array, callable $callback = null, $default = null) {
        if (is_null($callback)) {
            if (empty($array)) {
                return value($default);
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return value($default);
    });
}

if (!Arr::hasMacro('last')) {
    Arr::macro('last', function (array $array, callable $callback = null, $default = null) {
        if (is_null($callback)) {
            return empty($array) ? value($default) : end($array);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    });
}

if (!Arr::hasMacro('after')) {
    /**
     * Get the next item from the array.
     *
     * @param mixed $currentItem
     * @param mixed $fallback
     *
     * @return mixed
     */
    Arr::macro('after', function (array $array, $currentItem, $fallback = null) {
        $currentKey = static::search($array, $currentItem, true);
        if ($currentKey === false) {
            return $fallback;
        }
        $currentKeys = static::keys($array);

        $currentOffset = static::search($currentKeys, $currentKey, true);

        $next = static::slice($array, $currentOffset, 2);

        if (static::count($next) < 2) {
            return $fallback;
        }
        return static::last($next);
    });
}

if (!Arr::hasMacro('before')) {
    /**
     * Get the previous item from the array.
     *
     * @param mixed $currentItem
     * @param mixed $fallback
     *
     * @return mixed
     */
    Arr::macro('before', function (array $array, $currentItem, $fallback = null) {
        $reversed = static::reverse($array);
        return static::after($reversed, $currentItem, $fallback);
    });
}

if (!Arr::hasMacro('take')) {
    /**
     * Take the first or last {$limit} items.
     *
     * @param  int  $limit
     * @return static
     */
    Arr::macro('take', function (array $array, int $limit) {
        if ($limit < 0) {
            return static::slice($limit, abs($limit));
        }

        return static::slice(0, $limit);
    });
}

if (!Arr::hasMacro('reduce')) {
    /**
     * Reduce the array to a single value.
     *
     * @param  callable  $callback
     * @param  mixed  $initial
     * @return mixed
     */
    Arr::macro('reduce', function (array $array, callable $callback, $initial = null) {
        return array_reduce($array, $callback, $initial);
    });
}

if (!Arr::hasMacro('slice')) {
    /**
     * Slice the array.
     *
     * @param  int  $offset
     * @param  int  $length
     * @return static
     */
    Arr::macro('slice', function ($array, int $offset, int $length = null) {
        return array_slice($array, $offset, $length, true);
    });
}

if (!Arr::hasMacro('sliceAssoc')) {
    /**
     * Slice the array having associative keys.
     *
     * @param  int  $offset
     * @param  int  $length
     * @return static
     */
    Arr::macro('sliceAssoc', function (array $array, array $keys) {
        return array_intersect_key($array, array_flip($keys));
    });
}

if (!Arr::hasMacro('splice')) {
    /**
     * Splice a portion of the array.
     *
     * @param  int  $offset
     * @param  int|null  $length
     * @param  mixed  $replacement
     * @return static
     */
    Arr::macro('splice', function ($array, $offset, $length = null, $replacement = []) {
        if (func_num_args() == 1) {
            return array_splice($array, $offset);
        }

        return array_splice($array, $offset, $length, $replacement);
    });
}

if (!Arr::hasMacro('split')) {
    /**
     * Split a array into a certain number of groups.
     *
     * @param  int  $numberOfGroups
     * @return static
     */
    Arr::macro('split', function ($array, int $numberOfGroups) {
        if (static::isEmpty($array)) {
            return [];
        }

        $groupSize = ceil(static::count($array) / $numberOfGroups);

        return Arr::chunk($array, $groupSize);
    });
}

if (!Arr::hasMacro('partition')) {
    /**
     * Partition the array into two arrays using the given callback or key.
     *
     * @param  callable|string  $callback
     * @return static
     */
    Arr::macro('partition', function ($array) {
        $partitions = [[], []];

        $callback = static::valueRetriever($callback);

        foreach ($array as $key => $item) {
            $partitions[(int) !$callback($item)][$key] = $item;
        }

        return $partitions;
    });
}

if (!Arr::hasMacro('nth')) {
    /**
     * Create a new array consisting of every n-th element.
     *
     * @param  int  $step
     * @param  int  $offset
     * @return static
     */
    Arr::macro('nth', function ($array, $step, $offset = 0) {
        $new = [];

        $position = 0;

        foreach ($array as $item) {
            if ($position % $step === $offset) {
                $new[] = $item;
            }

            $position++;
        }

        return $new;
    });
}

if (!Arr::hasMacro('chunk')) {
    /**
     * Chunk the array.
     *
     * @param  int  $size
     * @return static
     */
    Arr::macro('chunk', function ($array, $size) {
        if ($size <= 0) {
            return [];
        }

        $chunks = [];

        foreach (array_chunk($array, $size, true) as $chunk) {
            $chunks[] = $chunk;
        }

        return $chunks;
    });
}

if (!Arr::hasMacro('transform')) {

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param  mixed  $value
     * @return bool
     */
    Arr::macro('transform', function ($array, callable $callback) {
        return static::map($array, $callback);
    });
}

if (!Arr::hasMacro('permutations')) {
    /**
     * Returns all possible permutations of $values containing $n elements using a
     * "draw and place back" algorithm
     *
     * The resulting array will always have pow(count($values), $n) entries.
     *
     * For
     *   $values = array('a', 'b') and $n = 2,
     * the result will contain:
     *   [aa, ab, ba, bb]
     *
     * @param array $values Vector to generate permutations of
     * @param int $n Elements per permutation
     * @return array Possible permutations
     */
    Arr::macro('permutatations', function ($values, $n) {
        $rec = function (array $values, &$ret, $n, array $cur = array()) use (&$rec) {
            if ($n > 0) {
                foreach ($values as $v) {
                    $newCur = $cur;
                    $newCur[] = $v;
                    $rec($values, $ret, $n - 1, $newCur);
                }
            } else {
                $ret[] = $cur;
            }
        };

        $ret = array();
        $rec($values, $ret, $n);

        return $ret;
    });
}

if (!Arr::hasMacro('combinations')) {
    Arr::macro('combinations', function ($array) {
        $results = array(array());

        foreach ($array as $element) {
            foreach ($results as $combination) {
                array_push($results, array_merge(array($element), $combination));
            }
        }

        return $results;
    });
}

if (!Arr::hasMacro('balance')) {
    /**
     * Equalize the size of two arrays.
     *
     * @param  array $a
     * @param  array $b
     * @param  bool  $pad
     * @return array
     */
    Arr::macro('balance', function (array $a, array $b, bool $pad = true) {
        $acount = count($a);
        $bcount = count($b);

        if ($pad) {
            $size = ($acount > $bcount) ? $bcount : $acount;
            $a = array_slice($a, 0, $size);
            $b = array_slice($b, 0, $size);
        } else {
            if ($acount > $bcount) {
                $more = $acount - $bcount;
                for ($i = 0; $i < $more; $i++) {
                    $key = 'extra_field_' . $i;
                    $b[$key] = "";
                }
            } elseif ($acount < $bcount) {
                $more = $bcount - $acount;
                for ($i = 0; $i < $more; $i++) {
                    $key = 'extra_field_' . $i;
                    $a[$key] = "";
                }
            }
        }
        return [$a, $b];
    });
}

if (!Arr::hasMacro('rotate')) {
    Arr::macro('rotate', function (array &$array) {
        $element = array_shift($array);
        array_push($array, $element);
        return $element;
    });
}

if (!Arr::hasMacro('shuffle')) {
    /**
     * Shuffle the items in the array.
     *
     * @param  int  $seed
     * @return static
     */
    Arr::macro('shuffle', function ($array, $seed = null) {
        $items = $array;

        if (is_null($seed)) {
            shuffle($items);
        } else {
            srand($seed);

            usort($items, function () {
                return rand(-1, 1);
            });
        }

        return $items;
    });
}

if (!Arr::hasMacro('random')) {
    /**
     * Get one or a specified number of random values from an array.
     *
     * @param  array  $array
     * @param  int|null  $number
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    Arr::macro('random', function ($array, $number = null) {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            throw new InvalidArgumentException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }

        if ((int) $number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array) $keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    });
}

if (!Arr::hasMacro('occurances')) {
    /**
     * Returns an associative array of values from
     * array as keys and their count as value.
     *
     * @param  array $array
     * @param  bool  $insensitive
     * @return array
     */
    Arr::macro('occurances', function (array $array, bool $insensitive = false) {
        if ($insensitive) {
            return array_count_values(array_map('strtolower', $array));
        }

        return array_count_values($array);
    });
}

if (!Arr::hasMacro('depth')) {
    /**
     * Return the depth of the array.
     */
    Arr::macro('depth', function ($array) {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = static::depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    });
}

if (!Arr::hasMacro('swapPositions')) {
    /**
     * Swap the position of two values in an array.
     */
    Arr::macro('swapPositions', function ($data, $left, $right) {
        $backup_old_data_right_value = $data[$right];
        $data[$right] = $data[$left];
        $data[$left] = $backup_old_data_right_value;
        return $data;
    });
}

if (!Arr::hasMacro('reverse')) {
    /**
     * Reverse items order.
     *
     * @return array
     */
    Arr::macro('reverse', function ($array) {
        return array_reverse($array, true);
    });
}

if (!Arr::hasMacro('reverseKeys')) {
    /**
     * Reverse keys of an array.
     *
     * @return array
     */
    Arr::macro('reverseKeys', function ($array) {
        return array_reverse(array_reverse($array, true), false);
    });
}

if (!Arr::hasMacro('flip')) {
    /**
     * Flip the items in the array.
     *
     * @return array
     */
    Arr::macro('flip', function ($array) {
        return array_flip($array);
    });
}

if (!Arr::hasMacro('transpose')) {
    /**
     * Transpose an array. Rows become columns, columns become rows.
     * E.g.     becomes
     *  [1,2]    [1,3]
     *  [3,4]    [2,4]
     *
     * @return \Illuminate\Support\Collection
     */
    Arr::macro('transpose', function ($array) {
        return static::make(array_map(function (...$items) {
            return $items;
        }, ...static::values($array)));
    });
}

if (!Arr::hasMacro('transposeWithKeys')) {
    /**
     * Transpose (flip) a array matrix (array of arrays) while keeping its columns and row headers intact.
     *
     * Please note that a row missing a column another row does have can only occur for one column. It cannot
     * parse more than one missing column.
     */
    Arr::macro('transposeWithKeys', function ($array, array $rows = null) {
        $rows = $rows ?? static::reduce(static::values($array), function (array $rows, array $values) {
            return array_unique(array_merge($rows, array_keys($values)));
        }, []);

        $keys = static::keys($array);

        // Transpose the matrix
        $items = array_map(function (...$items) use ($keys) {
            // The array's keys now become column headers
            return array_combine($keys, $items);
        }, ...static::values($array));

        // Add the new row headers
        $items = array_combine($rows, $items);

        return $items;
    });
}

if (!Arr::hasMacro('transposeStrict')) {
    /**
     * Transpose an array.
     *
     * @return array
     *
     * @throws \LengthException
     */
    Arr::macro('transposeStrict', function ($array) {
        $values = static::values($array);
        $expectedLength = count(static::first($array));
        $diffLength = count(array_intersect_key(...$values));
        if ($expectedLength !== $diffLength) {
            throw new \LengthException("Element's length must be equal.");
        }
        $items = array_map(function (...$items) {
            return $items;
        }, ...$values);
        return $items;
    });
}

if (!Arr::hasMacro('crossJoin')) {
    /**
     * Cross join the given arrays,
     * returning all possible permutations.
     *
     * @param  array  ...$arrays
     * @return array
     */
    Arr::macro('crossJoin', function (...$arrays) {
        $results = [[]];

        foreach ($arrays as $index => $array) {
            $append = [];

            foreach ($results as $product) {
                foreach ($array as $item) {
                    $product[$index] = $item;

                    $append[] = $product;
                }
            }

            $results = $append;
        }

        return $results;
    });
}

if (!Arr::hasMacro('innerJoin')) {
    /**
     * Inner join the given arrays.
     *
     * @param  array  ...$arrays
     * @return array
     */
    Arr::macro('innerJoin', function (array $left, array $right, $on) {
        $out = array();
        foreach ($left as $left_record) {
            foreach ($right as $right_record) {
                if ($left_record[$on] == $right_record[$on]) {
                    $out[] = array_merge($left_record, $right_record);
                }
            }
        }
        return $out;
    });
}

if (!Arr::hasMacro('outerJoin')) {
    /**
     * Outer join the given arrays.
     *
     * @param  array  ...$arrays
     * @return array
     */
    Arr::macro('outerJoin', function (array $left, array $right, $left_join_on, $right_join_on = null) {
        $final = array();

        if (empty($right_join_on)) {
            $right_join_on = $left_join_on;
        }

        foreach ($left as $k => $v) {
            $final[$k] = $v;
            foreach ($right as $kk => $vv) {
                if ($v[$left_join_on] == $vv[$right_join_on]) {
                    foreach ($vv as $key => $val) {
                        $final[$k][$key] = $val;
                    }
                } else {
                    foreach ($vv as $key => $val) {
                        $final[$k][$key] = null;
                    }
                }
            }
        }
        return $final;
    });
}

if (!Arr::hasMacro('union')) {
    /**
     * Obtain the true union two arrays
     *
     * In a venn diagram between A and B, this function
     * returns all values found exclusively in A and
     * exclusively in B and values shared between A and B.
     * (All Venn Diagram)
     *
     * @param  array  $a
     * @param  array  $b
     * @return array
     */
    Arr::macro('union', function (array $a, array $b) {
        return array_merge(
            array_intersect($a, $b), // B that also belong to A
            array_diff($a, $b), // A without B
            array_diff($b, $a) // B without A
        );
    });
}

if (!Arr::hasMacro('intersection')) {
    /**
     * Obtain the true intersection of two arrays.
     *
     * In a venn diagram between A and B, this function
     * returns all values shared between A and B.
     * (Center Venn Diagram)
     *
     * @param  array  $a
     * @param  array  $b
     * @return array
     */
    Arr::macro('intersection', function (array $a, array $b) {
        return array_merge(
            array_intersect($a, $b), // B that also belong to A
            array_diff($a, $b), // A without B
            array_diff($b, $a) // B without A
        );
    });
}

if (!Arr::hasMacro('difference')) {
    /**
     * Obtain the true difference of two arrays.
     *
     * In a venn diagram between A and B, this function
     * returns exclusive values of both A and B, but
     * not values shared between A and B.
     * (Left and Right Only Venn Diagram)
     *
     * @param  array  $a
     * @param  array  $b
     * @return array
     */
    Arr::macro('difference', function (array $a, array $b) {
        $intersect = array_intersect($a, $b);
        return array_merge(array_diff($a, $intersect), array_diff($b, $intersect));
    });
}

if (!Arr::hasMacro('rightDifference')) {
    /**
     * Obtain the true right difference.
     *
     * In a venn diagram between A and B, this function
     * returns values found exclusively in B, but not
     * values shared between A and B.
     * (Right Only Venn Diagram)
     *
     * @param  array $a
     * @param  array $b
     * @return array
     */
    Arr::macro('rightDifference', function (array $a, array $b) {
        $intersect = array_intersect($a, $b);
        return array_diff($b, $intersect);
    });
}

if (!Arr::hasMacro('rightUnion')) {
    /**
     * Obtain the true right union.
     *
     * In a venn diagram between A and B, this function
     * returns all values found exclusively in A and
     * values shared between A and B.
     * (Right and Center of Venn Diagram)
     *
     * @param  array $a
     * @param  array $b
     * @return array
     */
    Arr::macro('rightUnion', function (array $a, array $b) {
        return array_merge(
            array_intersect($a, $b), // B that also belong to A
            array_diff($b, $a) // A without B
        );
    });
}

if (!Arr::hasMacro('leftDifference')) {
    /**
     * Obtain the true left difference.
     *
     * In a venn diagram between A and B, this function
     * returns values found exclusively in A, but not
     * values shared between A and B.
     * (Left Only Venn Diagram)
     *
     * @param  array $a
     * @param  array $b
     * @return array
     */
    Arr::macro('leftDifference', function (array $a, array $b) {
        $intersect = array_intersect($a, $b); // B in A
        return array_diff($a, $intersect); // A without (B in A)
    });
}

if (!Arr::hasMacro('leftUnion')) {
    /**
     * Obtain the true left union.
     *
     * In a venn diagram between A and B, this function
     * returns all values found exclusively in A and and
     * commonly shared values.
     * (Left and Center of Venn Diagram)
     *
     * @param  array $a
     * @param  array $b
     * @return array
     */
    Arr::macro('leftUnion', function (array $a, array $b) {
        return array_merge(
            array_intersect($a, $b), // B that also belong to A
            array_diff($a, $b) // A without B
        );
    });
}

if (!Arr::hasMacro('intersect')) {
    /**
     * Intersect the array with the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('intersect', function ($array, $items) {
        return array_intersect($array, static::getArrayableItems($items));
    });
}

if (!Arr::hasMacro('intersectKey')) {
    /**
     * Intersect the array with the given items by key.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('intesectKey', function ($array, $items) {
        return array_intersect_key($array, static::getArrayableItems($items));
    });
}

if (!Arr::hasMacro('diff')) {
    /**
     * Get the items in the array that are not present in the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('diff', function ($array, $items) {
        return array_diff($array, static::getArrayableItems($items));
    });
}

if (!Arr::hasMacro('diffAssoc')) {
    /**
     * Get the items in the array whose keys and values are not present in the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('diffAssoc', function ($array, $items) {
        return array_diff_assoc($array, static::getArrayableItems($items));
    });
}

if (!Arr::hasMacro('diffKeys')) {
    /**
     * Get the items in the array whose keys are not present in the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('diffKeys', function ($array, $items) {
        return array_diff_key($array, static::getArrayableItems($items));
    });
}

if (!Arr::hasMacro('merge')) {
    /**
     * Merge the array with the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('merge', function ($array, $items) {
        return array_merge($array, static::getArrayableItems($items));
    });
}

if (!Arr::hasMacro('mergeFlatMap')) {
    Arr::macro('mergeFlatMap', function ($array, $callback) {
        return static::merge($array,
            static::flatMap($array, function ($item) use ($callback) {
                return $callback($item);
            })
        );
    });
}

if (!Arr::hasMacro('concat')) {
    /**
     * Push all of the given items onto the array.
     *
     * @param  \Traversable  $source
     * @return self
     */
    Arr::macro('concat', function ($source) {
        $result = [];

        foreach ($source as $item) {
            static::push($result, $item);
        }

        return $result;
    });
}

if (!Arr::hasMacro('combine')) {
    /**
     * Create a array by using this array for keys and another for its values.
     *
     * @param  mixed  $values
     * @return static
     */
    Arr::macro('combine', function ($array, $values) {
        return array_combine($array, static::getArrayableItems($values));
    });
}

if (!Arr::hasMacro('divide')) {
    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array  $array
     * @return array
     */
    Arr::macro('divide', function ($array) {
        return [array_keys($array), array_values($array)];
    });
}

if (!Arr::hasMacro('zip')) {
    /**
     * Zip the array together with one or more arrays.
     *
     * e.g. new Collection([1, 2, 3])->zip([4, 5, 6]);
     *      => [[1, 4], [2, 5], [3, 6]]
     *
     * @param  mixed ...$items
     * @return static
     */
    Arr::macro('zip', function ($array, $items) {
        $items = array_slice(func_get_args(), 1);

        $arrayableItems = array_map(function ($item) {
            return static::getArrayableItems($item);
        }, $items);

        $params = array_merge([function () use ($items) {
            return $items; //// TEST /////
        }, $array], $arrayableItems);

        return call_user_func_array('array_map', $params);
    });
}

if (!Arr::hasMacro('flatten')) {
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array  $array
     * @param  int  $depth
     * @return array
     */
    Arr::macro('flatten', function ($array) {
        return array_reduce($array, function ($result, $item) use ($depth) {
            $item = $item instanceof Collection ? $item->all() : $item;

            if (!is_array($item)) {
                return array_merge($result, [$item]);
            } elseif ($depth === 1) {
                return array_merge($result, array_values($item));
            } else {
                return array_merge($result, static::flatten($item, $depth - 1));
            }
        }, []);
    });
}

if (!Arr::hasMacro('collapse')) {
    /**
     * Collapse an array of arrays into a single array.
     *
     * @param  array  $array
     * @return array
     */
    Arr::macro('collapse', function ($array) {
        $results = [];

        foreach ($array as $values) {
            if ($values instanceof Collection) {
                $values = $values->all();
            } elseif (!is_array($values)) {
                continue;
            }

            $results = array_merge($results, $values);
        }

        return $results;
    });
}

if (!Arr::hasMacro('collapseWithKeys')) {
    /**
     * Collapse an array of arrays into a single array,
     * avoids using array_merge to preserve the keys.
     *
     * @param  array $array
     * @return array
     */
    Arr::macro('collapseWithKeys', function ($array) {
        $result = [];

        foreach ($array as $child) {
            if (is_array($child)) {
                foreach ($child as $key => $value) {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    });
}

if (!Arr::hasMacro('implode')) {
    /**
     * Concatenate values of an array.
     *
     * @param  string  $value
     * @param  string  $glue
     * @return string
     */
    Arr::macro('implode', function ($array, $glue = '') {
        return implode($glue, $array);
    });
}

if (!Arr::hasMacro('implodeWithKeys')) {
    /**
     * Concatenate values of a given key as a string.
     *
     * @param  string  $value
     * @param  string  $glue
     * @return string
     */
    Arr::macro('implodeWithKeys', function ($array, $value, $glue = null) {
        $first = static::first($array);

        if (is_array($first) || is_object($first)) {
            return implode($glue, static::pluck($array, $value));
        }

        return implode($value, $array);
    });
}

if (!Arr::hasMacro('implodeMulti')) {
    /**
     * Concatenate values of a given key as a string
     * in a multidimensional array.
     *
     * @param  string  $value
     * @param  string  $glue
     * @return string
     */
    Arr::macro('implodeMulti', function ($array, $glue = null) {
        $ret = '';

        foreach ($array as $item) {
            if (is_array($item)) {
                $ret .= static::implodeMulti($item, $glue) . $glue;
            } else {
                $ret .= $item . $glue;
            }
        }

        $ret = substr($ret, 0, 0 - strlen($glue));

        return $ret;
    });
}

if (!Arr::hasMacro('uppercase')) {
    Arr::macro('uppercase', function ($array) {
        return static::map($array, function ($item) {
            return strtoupper($item);
        });
    });
}

if (!Arr::hasMacro('isAccessible')) {
    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  $value
     * @return bool
     */
    Arr::macro('isAccessible', function ($value) {
        return is_array($value) || $value instanceof ArrayAccess;
    });
}

if (!Arr::hasMacro('isAssoc')) {
    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys
     * beginning with zero.
     *
     * @param  array  $array
     * @return bool
     */
    Arr::macro('isAssoc', function ($array) {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    });
}

if (!Arr::hasMacro('isIndexed')) {
    /**
     * Returns a value indicating whether the given array is an indexed array.
     *
     * An array is indexed if all its keys are integers. If `$consecutive` is true,
     * then the array keys must be a consecutive sequence starting from 0.
     *
     * Note that an empty array will be considered indexed.
     *
     * @param array $array the array being checked
     * @param bool $consecutive whether the array keys must be a consecutive sequence
     * in order for the array to be treated as indexed.
     * @return bool whether the array is associative
     */
    Arr::macro('isIndexed', function (array $array, bool $consecutive = false) {
        if (!is_array($array)) {
            return false;
        }
        if (empty($array)) {
            return true;
        }
        if ($consecutive) {
            return array_keys($array) === range(0, count($array) - 1);
        } else {
            foreach ($array as $key => $value) {
                if (!is_int($key)) {
                    return false;
                }
            }
            return true;
        }
    });
}

if (!Arr::hasMacro('isMulti')) {
    Arr::macro('isMulti', function ($array) {
        return count($array) != count($array, COUNT_RECURSIVE);
    });
}

if (!Arr::hasMacro('isEmpty')) {
    /**
     * Determine if the array is empty or not.
     *
     * @return bool
     */
    Arr::macro('isEmpty', function ($array) {
        return empty($array);
    });
}
if (!Arr::hasMacro('isNotEmpty')) {
    /**
     * Determine if the array is not empty.
     *
     * @return bool
     */
    Arr::macro('isNotEmpty', function ($array) {
        return !static::isEmpty($array);
    });
}

if (!Arr::hasMacro('has')) {
    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|array  $keys
     * @return bool
     */
    Arr::macro('has', function ($array, $keys) {
        if (is_null($keys)) {
            return false;
        }

        $keys = (array) $keys;

        if (!$array) {
            return false;
        }

        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subKeyArray = $array;

            if (static::exists($array, $key)) {
                continue;
            }

            foreach (explode('.', $key) as $segment) {
                if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }

        return true;
    });
}

if (!Arr::hasMacro('contains')) {
    /**
     * Determine if an item exists in the array.
     *
     * @param  mixed  $key
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return bool
     */
    Arr::macro('contains', function ($array, $key, $operator = null, $value = null) {
        if (func_num_args() == 2) {
            if (static::useAsCallable($key)) {
                return !is_null(static::first($array, $key));
            }

            return in_array($key, $array);
        }

        if (func_num_args() == 3) {
            $value = $operator;

            $operator = '=';
        }

        return static::contains($array, static::operatorForWhere($key, $operator, $value));
    });
}

if (!Arr::hasMacro('containsStrict')) {
    /**
     * Determine if an item exists in the array using strict comparison.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return bool
     */
    Arr::macro('containsStrict', function ($array, $key, $value = null) {
        if (func_num_args() == 3) {
            return static::contains($array, function ($item) use ($key, $value) {
                return data_get($item, $key) === $value;
            });
        }

        if (static::useAsCallable($key)) {
            return !is_null(static::first($array, $key));
        }

        return in_array($key, $array, true);
    });
}

if (!Arr::hasMacro('every')) {
    /**
     * Determine if all items in the array pass the given test.
     *
     * @param  string|callable  $key
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return bool
     */
    Arr::macro('every', function ($array, $key, $operator = null, $value = null) {
        if (func_num_args() == 2) {
            $callback = static::valueRetriever($key);

            foreach ($array as $k => $v) {
                if (!$callback($v, $k)) {
                    return false;
                }
            }

            return true;
        }

        if (func_num_args() == 3) {
            $value = $operator;

            $operator = '=';
        }

        return static::every(static::operatorForWhere($key, $operator, $value));
    });
}

if (!Arr::hasMacro('paginate')) {
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
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        $results = static::forPage($array, $page, $perPage);
        $total = $total ?: static::count($array);
        $options += [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ];
        return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
    });
}

if (!Arr::hasMacro('simplePaginate')) {
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
        $page = $page ?: Paginator::resolveCurrentPage($pageName);
        $sliced = static::slice($array, ($page - 1) * $perPage);
        $results = static::take($sliced, $perPage + 1);
        $options += [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ];
        return new Paginator($results, $perPage, $page, $options);
    });
}

if (!Arr::hasMacro('forPage')) {
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
}

if (!Arr::hasMacro('toSet')) {
    /**
     * Converts a model array into a dataset.
     * @param string $label  The column containing the labels for each set.
     * @param string $data   The column containing the values for each set.
     */
    Arr::macro('toSet', function ($array, $label, $value, $aggregate = null) {
        $groups = Arr::mapToGroups($array, function ($dataset) use ($label, $value) {
            return [$dataset[$label] => $dataset[$value]];
        });
        return Arr::map($groups, function ($group) use ($aggregate) {
            return Arr::aggregate($group, $aggregate);
        });
    });
}

if (!Arr::hasMacro('toSeries')) {
    /**
     * Converts a model array into a multi-dataset series.
     * @param string $series The column containg the series labels.
     * @param string $label  The column containing the labels for each set.
     * @param string $data   The column containing the values for each set.
     * @param string $data   The aggregate function to run on the data column.
     */
    Arr::macro('toSeries', function ($series, $label, $value, $aggregate = null) {
        $grouped = Arr::groupBy($series);

        return Arr::transform($grouped, function ($seriesData, $seriesLabel) use ($label, $value, $aggregate) {
            return Arr::toSet($seriesData, $label, $value, $aggregate);
        });
    });
}

if (!Arr::hasMacro('toArray')) {
    /**
     * Get the array of items as a plain array.
     *
     * @return array
     */
    Arr::macro('toArray', function ($array) {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $array);
    });
}

if (!Arr::hasMacro('toJson')) {
    /**
     * Get the array of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    Arr::macro('toJson', function ($array, $options = 0) {
        return json_encode(Arr::jsonSerialize($array), $options);
    });
}

if (!Arr::hasMacro('toString')) {
    /**
     * Convert the array to its string representation.
     *
     * @return string
     */
    Arr::macro('toString', function ($array) {
        return Arr::toJson($array);
    });
}

if (!Arr::hasMacro('toGeneric')) {
    Arr::macro('toGeneric', function ($array) {
        return (object) $array;
    });
}

if (!Arr::hasMacro('toGenericStrict')) {
    Arr::macro('toGeneric', function ($array) {
        return json_decode(json_encode($array), false);
    });
}

if (!Arr::hasMacro('toCollection')) {
    /*
     * Dump the contents of the array and terminate the script.
     */
    Arr::macro('toCollection', function ($array) {
        return collect($array);
    });
}

if (!Arr::hasMacro('toCollectionStrict')) {
    /*
     * Dump the contents of the array and terminate the script.
     */
    Arr::macro('toCollectionStrict', function ($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = Arr::toCollection($value);
                $array[$key] = $value;
            }
        }
        return collect($array);
    });
}

if (!Arr::hasMacro('make')) {
    /**
     * Create a new array instance if the value isn't one already.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('make', function ($item) {
        return (array) $item;
    });
}

if (!Arr::hasMacro('all')) {
    /**
     * Create a new array instance if the value isn't one already.
     *
     * @param  mixed  $items
     * @return static
     */
    Arr::macro('all', function ($array) {
        return (array) $array;
    });
}

if (!Arr::hasMacro('add')) {
    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    Arr::macro('add', function ($array, $key, $value) {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }

        return $array;
    });
}

if (!Arr::hasMacro('forget')) {
    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return void
     */
    Arr::macro('forget', function (&$array, $keys) {
        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            // clean up before each pass
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    });
}

if (!Arr::hasMacro('put')) {
    /**
     * Put an item in the array by key.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return $array
     */
    Arr::macro('put', function ($array, $key, $value) {
        return static::offsetSet($array, $key, $value);
    });
}

if (!Arr::hasMacro('push')) {
    /**
     * Push an item onto the end of the array.
     *
     * @param  mixed  $value
     * @return $array
     */
    Arr::macro('push', function ($array, $value) {
        return static::offsetSet($array, null, $value);
    });
}

if (!Arr::hasMacro('pull')) {
    /**
     * Get a value from the array, and remove it.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    Arr::macro('pull', function (&$array, $key, $default = null) {
        $value = static::get($array, $key, $default);

        static::forget($array, $key);

        return $value;
    });
}

if (!Arr::hasMacro('pop')) {
    /**
     * Get and remove the last item from the array.
     *
     * @return mixed
     */
    Arr::macro('pop', function () {
        return array_pop($array);
    });
}

if (!Arr::hasMacro('shift')) {
    /**
     * Get and remove the first item from the array.
     *
     * @return mixed
     */
    Arr::macro('shift', function ($array) {
        return array_shift($array);
    });
}

if (!Arr::hasMacro('prepend')) {
    /**
     * Push an item onto the beginning of an array.
     *
     * @param  array  $array
     * @param  mixed  $value
     * @param  mixed  $key
     * @return array
     */
    Arr::macro('prepend', function ($array, $value, $key = null) {
        if (is_null($key)) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }

        return $array;
    });
}

if (!Arr::hasMacro('get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    Arr::macro('get', function ($array, $key, $default = null) {
        if (!static::accessible($array)) {
            return value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }

        return $array;
    });
}

if (!Arr::hasMacro('offsetGet')) {
    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    Arr::macro('offsetGet', function ($array, $key) {
        return $array[$key];
    });
}

if (!Arr::hasMacro('set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    Arr::macro('set', function (&$array, $key, $value) {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    });
}

if (!Arr::hasMacro('offsetSet')) {
    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    Arr::macro('offsetSet', function ($array, $key, $value) {
        if (is_null($key)) {
            $array[] = $value;
        } else {
            $array[$key] = $value;
        }

        return $array;
    });
}

if (!Arr::hasMacro('offsetUnset')) {
    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    Arr::macro('offsetUnset', function ($array, $key) {
        unset($array[$key]);
        return $array;
    });
}

if (!Arr::hasMacro('exists')) {
    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @return bool
     */
    Arr::macro('exists', function ($array, $key) {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    });
}

if (!Arr::hasMacro('offsetExists')) {
    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    Arr::macro('offsetExists', function ($array, $key) {
        return array_key_exists($key, $array);
    });
}

if (!Arr::hasMacro('dot')) {
    Arr::macro('dot', function ($array, $prepend = '') {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    });
}

if (!Arr::hasMacro('undot')) {
    /**
     * Expands a dotted associative array. The inverse of Arr::dot().
     *
     * @param  array $array
     * @return array
     */
    Arr::macro('undot', function ($array) {
        $return = [];
        foreach ($array as $key => $value) {
            static::set($return, $key, $value);
        }
        return $return;
    });
}

if (!Arr::hasMacro('wrap')) {
    /**
     * If the given value is not an array, wrap it in one.
     *
     * @param  mixed  $value
     * @return array
     */
    Arr::macro('wrap', function ($value) {
        return !is_array($value) ? [$value] : $value;
    });
}

if (!Arr::hasMacro('explodePluckParameters')) {
    /**
     * Explode the "value" and "key" arguments passed to "pluck".
     *
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    Arr::macro('explodePluckParameters', function ($value, $key) {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        return [$value, $key];
    });
}

if (!Arr::hasMacro('jsonSerialize')) {
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
}

if (!Arr::hasMacro('valueRetriever')) {
    /**
     * Get a value retrieving callback.
     *
     * @param  string  $value
     * @return callable
     */
    Arr::macro('valueRetriever', function ($value) {
        if (Arr::useAsCallable($value)) {
            return $value;
        }
        $result = function ($item) use ($value) {
            return data_get($item, $value);
        };
        return $result;
    });
}

if (!Arr::hasMacro('useAsCallable')) {
    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param  mixed  $value
     * @return bool
     */
    Arr::macro('useAsCallable', function ($value) {
        return !is_string($value) && is_callable($value);
    });
}

if (!Arr::hasMacro('getArrayableItems')) {
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
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_decode($items->toJson(), true);
        } elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    });
}

if (!Arr::hasMacro('getCachingIterator')) {
    /**
     * Get a CachingIterator instance.
     *
     * @param  int  $flags
     * @return \CachingIterator
     */
    Arr::macro('getIterator', function ($array, $flags = CachingIterator::CALL_TOSTRING) {
        return new CachingIterator(Arr::getIterator($array), $flags);
    });
}

if (!Arr::hasMacro('operatorForWhere')) {
    /**
     * Get an operator checker callback.
     *
     * @param  string  $key
     * @param  string  $operator
     * @param  mixed  $value
     * @return \Closure
     */
    Arr::macro('operatorForWhere', function ($key, $operator, $value) {
        return function ($item) use ($key, $operator, $value) {
            $retrieved = data_get($item, $key);

            switch ($operator) {
                default:
                case '=':
                case '==':return $retrieved == $value;
                case '!=':
                case '<>':return $retrieved != $value;
                case '<':return $retrieved < $value;
                case '>':return $retrieved > $value;
                case '<=':return $retrieved <= $value;
                case '>=':return $retrieved >= $value;
                case '===':return $retrieved === $value;
                case '!==':return $retrieved !== $value;
            }
        };
    });
}

if (!Arr::hasMacro('toAssoc')) {
    Arr::macro('toAssoc', function ($array) {
        return Arr::reduce($array, function ($assoc, $keyValuePair) {
            list($key, $value) = $keyValuePair;
            $assoc[$key] = $value;
            return $assoc;
        }, []);
    });
}

if (!Arr::hasMacro('dump')) {
    /*
     * Dump the arguments given followed by the array.
     */
    Arr::macro('dump', function ($array) {
        $made = Arr::make(array_slice(func_get_args(), 1));
        $pushed = Arr::push($array, $made);
        $result = Arr::each($pushed, function ($item) {
            (new Dumper)->dump($item);
        });

        return $result;
    });
}
