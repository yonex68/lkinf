<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class CategoriesFixtures extends Fixture
{
    private $sluger;

    public function __construct(SluggerInterface $sluger)
    {
        $this->sluger = $sluger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $categories = [
            1 => [
                'name' => 'Acoustic',
            ],
            2 => [
                'name' => 'Ambient',
            ],
            3 => [
                'name' => 'Blues',
            ],
            4 => [
                'name' => 'Classical',
            ],
            5 => [
                'name' => 'Electronic',
            ],
            6 => [
                'name' => 'Emo',
            ],
            7 => [
                'name' => 'Hip-Hop',
            ],
            8 => [
                'name' => 'Indie',
            ],
            9 => [
                'name' => 'Jazz',
            ],
            10 => [
                'name' => 'Latin',
            ],
            11 => [
                'name' => 'Metal',
            ],
            12 => [
                'name' => 'Pop',
            ],
            13 => [
                'name' => 'Pop punk',
            ],
            14 => [
                'name' => 'Punk',
            ],
            15 => [
                'name' => 'Reggae',
            ],
            16 => [
                'name' => 'R&B',
            ],
            17 => [
                'name' => 'Rock',
            ],
            18 => [
                'name' => 'Soul',
            ],
            19 => [
                'name' => 'World',
            ],
            20 => [
                'name' => 'Country',
            ],
        ];

        foreach($categories as $key => $value){

            $categorie = new Categorie();
            
            $categorie->setName($value['name']);
            $categorie->setSlug($this->sluger->slug($value['name']));
            $categorie->setHexColor($faker->hexColor());
            $manager->persist($categorie);

            // Enregistre la catégorie dans une référence
            $this->addReference('categorie_' . $key, $categorie);
        }

        $manager->flush();
    }
}
