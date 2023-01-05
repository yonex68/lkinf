<?php

namespace App\Controller\Vendeur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendeur')]
class VendeurDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'vendeur_dashboard')]
    public function index(): Response
    {
        return $this->render('vendeur/dashboard/index.html.twig', [
            'controller_name' => 'VendeurDashboardController',
        ]);
    }
}
