<?php

namespace App\Service;

class Traduction
{
    private array $tradEnFr = [
        'small' => 'petite',
        'medium' => 'moyenne',
        'large' => 'grande',
    ];

    public function __construct()
    {
    }

    function translateEnFr(string $en): string
    {
        return strtolower($this->tradEnFr[strtolower($en)]);
    }

}