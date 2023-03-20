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
     * @var string
     */
    public $ville = null;

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

    /**
     * @var ArrayCollection
     */
    public $villes;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->villes = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getVilles(): ArrayCollection
    {
        return $this->villes;
    }

    /**
     * @param ArrayCollection $Villes
     */
    public function setVilles(ArrayCollection $Villes): void
    {
        $this->villes = $Villes;
    }
}