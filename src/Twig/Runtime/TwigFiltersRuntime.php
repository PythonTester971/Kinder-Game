<?php

namespace App\Twig\Runtime;

use App\Repository\CategoryRepository;
use Twig\Extension\RuntimeExtensionInterface;

class TwigFiltersRuntime implements RuntimeExtensionInterface
{

    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
        // Inject dependencies if needed
    }

    // public function doSomething($value)
    // {
    //     // ...
    // }

    public function getCoucou()
    {
        return 'Coucou les gens';
    }

    public function  notice($string)
    {
        return '!!!' . strtoupper($string) . '!!!';
    }

    public function prix($price)
    {

        return number_format($price, 2, ',') . " €";
    }

    public function cutText($text, $length = 60)
    {
        if (strlen($text) > $length) {

            return substr($text, 0, $length) . '...';
        } else {

            return $text;
        }
    }

    public function categories()
    {
        return $this->categoryRepository->findAll();
    }
}
