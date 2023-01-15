<?php

namespace App\Controller\Vendeur;

use App\Entity\Microservice;
use App\Form\Microservice\MicroserviceGalerieType;
use App\Form\Microservice\MicroserviceType;
use App\Repository\MicroserviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/vendeur/services')]
class VendeurMicroservicesController extends AbstractController
{
    private $sluger;

    public function __construct(SluggerInterface $sluger)
    {
        $this->sluger = $sluger;
    }

    #[Route('/', name: 'vendeur_microservices_index', methods: ['GET'])]
    public function index(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        $microservices = $paginator->paginate(
            $microserviceRepository->findBy(['vendeur' => $user], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('vendeur/microservices/index.html.twig', [
            'microservices' => $microservices,
        ]);
    }

    #[Route('/new', name: 'vendeur_microservices_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $microservice = new Microservice();
        $form = $this->createForm(MicroserviceType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $microservice->getName() . '-' . $microservice->getId();

            $microservice->setSlug(strtolower($this->sluger->slug($slug)));
            $microservice->setVendeur($this->getUser());
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_galerie', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendeur/microservices/new.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/galerie', name: 'vendeur_microservices_galerie', methods: ['GET', 'POST'])]
    public function galeries(Request $request, EntityManagerInterface $entityManager, Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

        $form = $this->createForm(MicroserviceGalerieType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_show', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendeur/microservices/galerie.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vendeur_microservices_show', methods: ['GET'])]
    public function show(Microservice $microservice): Response
    {
        return $this->render('vendeur/microservices/show.html.twig', [
            'microservice' => $microservice,
        ]);
    }

    #[Route('/{id}/edit', name: 'vendeur_microservices_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Microservice $microservice, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);
        
        $form = $this->createForm(MicroserviceType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $form->get('name')->getData() . '-' . $microservice->getId();

            $microservice->setSlug(strtolower($this->sluger->slug($slug)));

            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été modifier!');

            return $this->redirectToRoute('vendeur_microservices_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendeur/microservices/edit.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vendeur_microservices_delete', methods: ['POST'])]
    public function delete(Request $request, Microservice $microservice, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);
        
        if ($this->isCsrfTokenValid('delete'.$microservice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($microservice);
            $entityManager->flush();
            $this->addFlash('success', 'Le contenu a bien été supprimer!');
        }

        return $this->redirectToRoute('vendeur_microservices_index', [], Response::HTTP_SEE_OTHER);
    }
}
