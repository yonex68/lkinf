<?php

namespace App\Controller;

use App\Entity\Microservice;
use App\Repository\MicroserviceRepository;
use App\Repository\PrixRepository;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/details/{slug}', name: 'microservice_details')]
    public function details(Microservice $microservice, PrixRepository $prixRepository): Response
    {
        return $this->render('microservice/details.html.twig', [
            'microservice' => $microservice,
            'prix' => $microservice->getPrix(),
        ]);
    }
}
