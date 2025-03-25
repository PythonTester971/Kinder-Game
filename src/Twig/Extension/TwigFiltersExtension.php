<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TwigFiltersRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigFiltersExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [TwigFiltersRuntime::class, 'doSomething']),
            new TwigFilter('notice', [TwigFiltersRuntime::class, 'notice']),
            new TwigFilter('prix', [TwigFiltersRuntime::class, 'prix']),
            new TwigFilter('cut_text', [TwigFiltersRuntime::class, 'cutText']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_categories', [TwigFiltersRuntime::class, 'categories']),
            new TwigFunction('coucou', [TwigFiltersRuntime::class, 'getCoucou'])
        ];
    }
}
