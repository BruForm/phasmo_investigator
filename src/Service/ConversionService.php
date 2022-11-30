<?php

namespace App\Service;

class ConversionService
{
    public function __construct()
    {
    }

    public function minSecInStr(string $min, string $sec): string
    {
        $minSecStr = "";
        if ($min > 0) {
            $min = ($min < 10) ? $min[1] : $min;
            $minSecStr .= $min . 'min';
        }
        if ($sec > 0) {
            $sec = ($sec < 10) ? $sec[1] : $sec;
            if ($minSecStr != "") {
                $minSecStr .= ' ';
            }
            $minSecStr .= $sec . 'sec';
        }
        return $minSecStr;
    }
}