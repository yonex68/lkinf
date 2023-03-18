<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(MicroserviceRepository $microserviceRepository, UserRepository $userRepository, CategorieRepository $categorieRepository, Request $request): Response
    {
        $user = $this->getUser();

        $session = $request->getSession();

        $session->set('nom', 'Malonga');

        //dd($session->get('nom'));

        if ($user) {
            $microservices = $microserviceRepository->findBylocation($user->getAdresse());
            $vendeurs = $userRepository->findByLocation($user->getAdresse());
        }else{
            $microservices = $microserviceRepository->findBy(['online' => 1], ['created' => 'DESC'], 6);
            $vendeurs = $userRepository->findBy(['compte' => 'vendeur'], ['created' => 'DESC'], 6);
        }
        
        return $this->render('accueil/index.html.twig', [
            'microservices' => $microservices,
            'vendeurs' => $vendeurs,
            'categories' => $categorieRepository->findBy([], ['created' => 'DESC'], 6)
        ]);
    }
}
