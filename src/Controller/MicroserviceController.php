<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Microservice;
use App\Form\CommandeType;
use App\Repository\MicroserviceRepository;
use App\Repository\PrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\TextUI\Command;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/microservices')]
class MicroserviceController extends AbstractController
{
    #[Route('/', name: 'microservices')]
    public function index(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $microservices = $paginator->paginate(
            $microserviceRepository->findBy(['online' => 1], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('microservice/index.html.twig', [
            'microservices' => $microservices,
        ]);
    }

    #[Route('/details/{slug}', name: 'microservice_details', methods: ['GET', 'POST'])]
    public function details(Microservice $microservice, Request $request, EntityManagerInterface $entityManager, MicroserviceRepository $microserviceRepository): Response
    {

        $similaires = $microserviceRepository->findBy(['vendeur' => $this->getUser()], ['created' => 'DESC'], 12);

        return $this->render('microservice/details.html.twig', [
            'microservice' => $microservice,
            'similaires' => $similaires,
            'prix' => $microservice->getPrix(),
        ]);
    }
}
