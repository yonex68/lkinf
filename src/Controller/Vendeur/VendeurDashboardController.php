<?php

namespace App\Controller\Vendeur;

use App\Entity\Portefeuille;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendeur')]
class VendeurDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'vendeur_dashboard')]
    public function index(EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if(!$user->getPortefeuille()){
            
            $portefeuille = new Portefeuille();
            $portefeuille->setVendeur($user);
            $portefeuille->setSoldeDisponible(0);
            $portefeuille->setSoldeEnCours(0);

            $manager->persist($portefeuille);
            $manager->flush();
        }

        return $this->render('vendeur/dashboard/index.html.twig', [
            'controller_name' => 'VendeurDashboardController',
        ]);
    }
}
