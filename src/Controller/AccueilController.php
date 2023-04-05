<?php

namespace App\Controller;

use App\Entity\SearchService;
use App\Form\HomeServiceType;
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

        $service = new SearchService();

        $form = $this->createForm(HomeServiceType::class, $service, [
            'action' => $this->generateUrl('microservices'),
            'method' => 'GET',
        ]);

        $microservices = $microserviceRepository->findBy(['online' => 1], ['created' => 'DESC'], 8);
        $vendeurs = $userRepository->findBy(['compte' => 'vendeur'], ['created' => 'DESC'], 6);

        return $this->render('accueil/index.html.twig', [
            'microservices' => $microservices,
            'vendeurs' => $vendeurs,
            'form' => $form->createView(),
            'categories' => $categorieRepository->findBy([], ['created' => 'DESC'], 6)
        ]);
    }
}
