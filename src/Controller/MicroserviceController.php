<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Microservice;
use App\Entity\SearchService;
use App\Form\CommandeType;
use App\Form\SearchServiceType;
use App\Repository\CategorieRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\PrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\TextUI\Command;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/microservices')]
class MicroserviceController extends AbstractController
{
    #[Route('/', name: 'microservices', methods: ['GET'])]
    public function index(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request, CategorieRepository $categorieRepository): Response
    {
        $search = new SearchService();
        $search->page = $request->get('page', 1);

        $form = $this->createForm(SearchServiceType::class, $search);
        $form->handleRequest($request);

        $microservices = $microserviceRepository->findSearch($search);
        $categories = $categorieRepository->findBy([], ['created' => 'DESC']);

        if($request->get('ajax')){

            return new JsonResponse([
                'content' => $this->renderView('microservice/composants/_listing.html.twig', ['microservices' => $microservices]),
                'sorting' => $this->renderView('microservice/composants/_sorting.html.twig', ['microservices' => $microservices]),
                'form' => $this->renderView('microservice/composants/_search_form.html.twig', ['microservices' => $microservices, 'form' => $form->createView()]),
                'pagination' => $this->renderView('microservice/composants/_pagination.html.twig', ['microservices' => $microservices]),
            ]);
        }

        return $this->renderForm('microservice/index.html.twig', [
            'microservices' => $microservices,
            'categories' => $categories,
            'form' => $form,
            'query' => $search->q,
        ]);
    }

    #[Route('/categories/{slug}', name: 'microservices_categories')]
    public function categories(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request, CategorieRepository $categorieRepository, $slug): Response
    {
        $search = new SearchService();
        $search->page = $request->get('page', 1);

        $form = $this->createForm(SearchServiceType::class, $search);
        $form->handleRequest($request);

        $microservices = $microserviceRepository->findSearch($search);
        $categories = $categorieRepository->findBy([], ['created' => 'DESC']);

        if($request->get('ajax')){

            return new JsonResponse([
                'content' => $this->renderView('microservice/composants/_listing.html.twig', ['microservices' => $microservices]),
                'sorting' => $this->renderView('microservice/composants/_sorting.html.twig', ['microservices' => $microservices]),
                'form' => $this->renderView('microservice/composants/_search_form.html.twig', ['microservices' => $microservices, 'form' => $form->createView()]),
                'pagination' => $this->renderView('microservice/composants/_pagination.html.twig', ['microservices' => $microservices]),
            ]);
        }

        return $this->render('microservice/categories.html.twig', [
            'microservices' => $microservices,
            'categories' => $categories,
            'form' => $form->createView(),
            'categorie' => $categorieRepository->findOneBy(['slug' => $slug]),
        ]);
    }

    #[Route('/{slug}', name: 'microservice_details', methods: ['GET', 'POST'])]
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
