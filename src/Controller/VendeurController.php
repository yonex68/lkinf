<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MicroserviceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendeurController extends AbstractController
{
    #[Route('/vendeurs', name: 'vendeur')]
    public function index(): Response
    {
        return $this->render('vendeur/index.html.twig', [
            'controller_name' => 'VendeurController',
        ]);
    }

    #[Route('/compte/vendeurs/{nameUrl}', name: 'vendeur_profil')]
    public function profil(User $user, MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $microservices = $paginator->paginate(
            $microserviceRepository->findBy([
                'vendeur' => $user,
                'online' => true
            ], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('vendeur/profil.html.twig', [
            'user' => $user,
            'microservices' => $microservices
        ]);
    }
}
