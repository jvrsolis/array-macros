<?php

use Illuminate\Support\Arr;

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