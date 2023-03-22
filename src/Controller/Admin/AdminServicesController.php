<?php

namespace App\Controller\Admin;

use App\Entity\Microservice;
use App\Entity\SearchService;
use App\Form\AdminSearchServiceType;
use App\Form\MicroserviceType;
use App\Form\SearchServiceType;
use App\Repository\MicroserviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/services')]
class AdminServicesController extends AbstractController
{
    #[Route('/', name: 'app_admin_services_index', methods: ['GET'])]
    public function index(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new SearchService();
        $search->page = $request->get('page', 1);

        $form = $this->createForm(AdminSearchServiceType::class, $search);
        $form->handleRequest($request);

        $microservices = $microserviceRepository->findAdminSearch($search);

        return $this->render('admin/admin_services/index.html.twig', [
            'microservices' => $microservices,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_admin_services_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $microservice = new Microservice();
        $form = $this->createForm(MicroserviceType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($microservice);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_services/new.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_services_show', methods: ['GET'])]
    public function show(Microservice $microservice): Response
    {
        return $this->render('admin/admin_services/show.html.twig', [
            'microservice' => $microservice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_services_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Microservice $microservice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MicroserviceType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_services/edit.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_services_delete', methods: ['POST'])]
    public function delete(Request $request, Microservice $microservice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$microservice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($microservice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_services_index', [], Response::HTTP_SEE_OTHER);
    }
}
