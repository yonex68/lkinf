<?php

namespace App\DataFixtures;

use App\Entity\Stripe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class StripeFixtures extends Fixture implements DependentFixtureInterface
{
    private $sluger;

    public function __construct(SluggerInterface $sluger)
    {
        $this->sluger = $sluger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $stripes = [
            1 => [
                'name' => 'Base',
                'tarif' => 50,
                'stripeKey' => 'price_1LnlytKh8lE9zjqNDYA6vCxo',
            ],
            2 => [
                'name' => 'Intermediaire',
                'tarif' => 150,
                'stripeKey' => 'price_1LrQLhKh8lE9zjqNbhY9UrRj',
            ],
            3 => [
                'name' => 'Premium',
                'tarif' => 250,
                'stripeKey' => 'price_1LrQNiKh8lE9zjqNT9typ7V7',
            ],
        ];

        foreach($stripes as $key => $value){

            //$user = $this->getReference('user_'. $faker->numberBetween(1, 2));

            $stripe = new Stripe();
            $stripe->setName($value['name']);
            $stripe->setTarif($value['tarif']);
            $stripe->setStripeKey($value['stripeKey']);
            //$stripe->setHexhaDecimal($faker->hexColor());
            $manager->persist($stripe);

            // Enregistre la catégorie dans une référence
            $this->addReference('stripe_' . $key, $stripe);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}
