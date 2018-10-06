<?php

use Illuminate\Support\Arr;

Arr::macro('parseRegex', function ($string, $headers = null, $delimiter = '/\s+/', $escape = "\n", $multiple = false) {

    $string = trim($string);

    $lines = explode($escape, $string);

    if ($multiple) {
        if ($headers === true) {
            preg_match($delimiter, array_shift($lines), $matches);
            array_shift($matches);
            $headers = $matches;
        }
    } else {
        if ($headers === true) {
            $headers = preg_split($delimiter, array_shift($lines));
        }
    }

    if (!empty($headers)) {
        foreach ($headers as $key => $header) {
            $headers[$key] = trim($header);
        }
    }

    $data = [];

    foreach ($lines as $line) {
        $row = [];
        if ($multiple) {
            preg_match($delimiter, $line, $matches);
            array_shift($matches);

            $values = $matches;
        } else {
            $values = preg_split($delimiter, trim($line));
        }
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