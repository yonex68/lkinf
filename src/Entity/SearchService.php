<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Categorie;

class SearchService {

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = null;

    /**
     * @var int|null
     */
    public $minPrice;

    /**
     * @var int|null
     */
    public $maxPrice;

    /**
     * @var bool|null
     */
    public $promo;

    /**
     * @var ArrayCollection
     */
    public $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     */
    public function setCategories(ArrayCollection $categories): void
    {
        $this->categories = $categories;
    }
}