<?php

use Illuminate\Support\Arr;

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
                    list($result, $atDepth) = Arr::searchRobust($value, $needle, $ith, $nth, $depth, $level, $key);

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