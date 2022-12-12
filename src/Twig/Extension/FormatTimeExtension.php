<?php

namespace App\Twig\Extension;

use phpDocumentor\Reflection\Types\This;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Service\ConversionService;

class FormatTimeExtension extends AbstractExtension
{
    public ConversionService $conversionService;
    public function __construct(ConversionService $conversionService)
    {
        $this->conversionService = $conversionService;
    }


    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_time', [$this, 'formatTime']),
        ];
    }

    public function formatTime($time): string
    {
        $min = date_format($time, 'i');
        $sec = date_format($time, 's');
        return $this->conversionService->minSecInStr($min, $sec);
    }
}
