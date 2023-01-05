<?php

namespace App\Twig;

use App\Repository\CategorieRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $categorieRepositorye;

    public function __construct(CategorieRepository $categorieRepositorye){

        $this->categorieRepositorye = $categorieRepositorye;

    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('categories', [$this, 'getCategories']),
        ];
    }

    public function getCategories(){
        return $this->categorieRepositorye->findAll([], ['name' => 'ASC']);
    }

    public function doSomething($value)
    {
        // ...
    }
}
