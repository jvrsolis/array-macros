<?php

use Illuminate\Support\Arr;

Arr::macro('parse', function ($string, $headers = null, $delimiter = ',', $escape = "\n") {

    $string = trim($string);

    $lines = explode($escape, $string);

    if ($headers === true) {
        $headers = str_getcsv(array_shift($lines), $delimiter);
    }

    if (!empty($headers)) {
        foreach ($headers as $key => $header) {
            $headers[$key] = trim($header);
        }
    }

    $data = [];

    foreach ($lines as $line) {
        $row = [];
        $values = str_getcsv(trim($line), $delimiter);

        foreach ($values as $key => $field) {
            if (!empty($headers)) {
                if (key_exists($key, $headers)) {
                    $row[$headers[$key]] = trim($field);
                }
            } else {
                $row[$key] = trim($field);
            }
        }

        $data[] = $row;
    }

    return $data;
});