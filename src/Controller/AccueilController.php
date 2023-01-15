<?php

namespace App\Controller;

use App\Repository\MicroserviceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(MicroserviceRepository $microserviceRepository, UserRepository $userRepository): Response
    {
        return $this->render('accueil/index.html.twig', [
            'microservices' => $microserviceRepository->findBy(['online' => 1], ['created' => 'DESC'], 6),
            'vendeurs' => $userRepository->findBy(['compte' => 'vendeur'], ['created' => 'DESC'], 6)
        ]);
    }
}
