<?php

namespace App\Controller\Vendeur;

use App\Entity\Disponibilite;
use App\Entity\Media;
use App\Entity\Microservice;
use App\Form\MediaType;
use App\Form\Microservice\DescriptionType;
use App\Form\Microservice\DisponibiliteType;
use App\Form\Microservice\IngenieurSonType;
use App\Form\Microservice\MicroserrviceOptionType;
use App\Form\Microservice\MicroserviceDisponibiliteType;
use App\Form\Microservice\MicroserviceGalerieType;
use App\Form\Microservice\MicroservicePublierType;
use App\Form\Microservice\MicroserviceTitreType;
use App\Form\Microservice\MicroserviceType;
use App\Repository\DisponibiliteRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\SuivisRepository;
use App\Service\MailerService;
use App\Service\VerifyAbonnementService;
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

        if (empty($user->getAdresse())) {
            $this->addFlash('warning', 'Veuillez indiquer votre lieu de la prestation de service pour completer votre compte');
            return $this->redirectToRoute('user_edit_adresse');
        }

        $microservices = $paginator->paginate(
            $microserviceRepository->findBy(['vendeur' => $user], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('vendeur/microservices/index.html.twig', [
            'microservices' => $microservices,
        ]);
    }

    #[Route('/nouveau-service', name: 'vendeur_microservices_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerService $mailer, SuivisRepository $suivisRepository, VerifyAbonnementService $verifyAbonnementService): Response
    {
        /** Verification de l'abonnement de l'utilisateur */
        $user = $this->getUser();
        
        /*if ($verifyAbonnementService->verifyAbonnement($user) === false) {
            return $this->redirectToRoute('stripe_abonnement_services');
        }*/

        $microservice = new Microservice();
        $form = $this->createForm(MicroserviceTitreType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $microservice->getName() . '-' . $microservice->getId();

            $microservice->setSlug(strtolower($this->sluger->slug($slug)));
            $microservice->setVendeur($this->getUser());
            $microservice->setPrixMastering(0);
            $microservice->setPrixMixage(0);
            $microservice->setPrixBeatmaking(0);
            $microservice->setPrixComposition(0);
            $microservice->setPrix(0);
            $microservice->setPromo(false);
            $microservice->setOffline(false);
            $entityManager->persist($microservice);
            $entityManager->flush();

            // Liste des clients qui le suivent
            /*$vendeur = $this->getUser();
            $suivis = $suivisRepository->findBy(['vendeur' => $vendeur]);
            //dd($suivis);

            if (count($suivis) > 0) {

                foreach ($suivis as $suivi) {

                    if (!empty($suivi->getClient())) {
                        $mailer->sendMail(
                            $vendeur->getEmail(),
                            $suivi->getClient()->getEmail(),
                            'Nouvelle publication',
                            $vendeur->getNom() . ' ' . $vendeur->getPrenom(),
                            'Nouveau message',
                            $microservice
                        );
                    }
                }
            }*/

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_description', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendeur/microservices/titre.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/titre', name: 'vendeur_microservices_titre', methods: ['GET', 'POST'])]
    public function titre(Request $request, EntityManagerInterface $entityManager, Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

        $form = $this->createForm(MicroserviceTitreType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $form->get('name')->getData() . '-' . $microservice->getId();

            $microservice->setSlug(strtolower($this->sluger->slug($slug)));
            
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_description', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendeur/microservices/titre.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/description', name: 'vendeur_microservices_description', methods: ['GET', 'POST'])]
    public function description(Request $request, EntityManagerInterface $entityManager, Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

        $formType = DescriptionType::class;

        if ($microservice->getCategorie()->getSlug() == 'ingenieur-son') {

            $formType = IngenieurSonType::class;

        }else{
            $formType = DescriptionType::class;
        }

        $form = $this->createForm($formType, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_options', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vendeur/microservices/description.html.twig', [
            'microservice' => $microservice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/options', name: 'vendeur_microservices_options', methods: ['GET', 'POST'])]
    public function options(Request $request, EntityManagerInterface $entityManager, Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

        $form = $this->createForm(MicroserrviceOptionType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('vendeur_microservices_galerie', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vendeur/microservices/options.html.twig', [
            'microservice' => $microservice,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/galerie', name: 'vendeur_microservices_galerie', methods: ['GET', 'POST'])]
    public function galeries(Request $request, EntityManagerInterface $entityManager, Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

        $form = $this->createForm(MicroserviceGalerieType::class, $microservice);
        $form->handleRequest($request);

        $media = new Media();
        $mediaForm = $this->createForm(MediaType::class, $media);
        $mediaForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', "La galérie a bien mise à jour");

            return $this->redirectToRoute('vendeur_microservices_disponibilite', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            $media->setMicroservice($microservice);
            $entityManager->persist($media);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_galerie', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vendeur/microservices/galerie.html.twig', [
            'microservice' => $microservice,
            'form' => $form->createView(),
            'mediaForm' => $mediaForm->createView(),
        ]);
    }

    #[Route('/{id}/disponibilite', name: 'vendeur_microservices_disponibilite', methods: ['GET', 'POST'])]
    public function planning(Request $request, EntityManagerInterface $entityManager, Microservice $microservice, DisponibiliteRepository $disponibiliteRepository): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);
        
        $form = $this->createForm(MicroserviceDisponibiliteType::class, $microservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('vendeur_microservices_publication', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        $disponibilite = new Disponibilite();
        $disponibiliteForm = $this->createForm(DisponibiliteType::class, $disponibilite);
        $disponibiliteForm->handleRequest($request);

        if ($disponibiliteForm->isSubmitted() && $disponibiliteForm->isValid()) {

            $jour = $disponibiliteForm->get('jour')->getData();
            $ordre = $this->getOrdre($jour);
            $findDisponibilite = $disponibiliteRepository->findOneBy([
                'jour' => $jour, 'service' => $microservice
            ]);

            if ($findDisponibilite) {
                $disponibilite = $findDisponibilite;
            }
            
            $disponibilite->setService($microservice);
            $disponibilite->setOrdre($ordre);
            $entityManager->persist($disponibilite);
            $entityManager->flush();

            $this->addFlash('success', "La disponibilité pour ce service a bien été mise à jour sur ce service");

            return $this->redirectToRoute('vendeur_microservices_disponibilite', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vendeur/microservices/disponibilite.html.twig', [
            'microservice' => $microservice,
            'form' => $form->createView(),
            'disponibiliteForm' => $disponibiliteForm->createView(),
            'disponibilites' => $disponibiliteRepository->findBy(['service' => $microservice], ['ordre' => 'ASC']),
        ]);
    }

    #[Route('/{id}/publication', name: 'vendeur_microservices_publication', methods: ['GET', 'POST'])]
    public function publication(Request $request, EntityManagerInterface $entityManager, Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

        $form = $this->createForm(MicroservicePublierType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $microservice->setOnline(true);
            $entityManager->persist($microservice);
            $entityManager->flush();

            $this->addFlash('success', 'Le contenu a bien été cré');

            return $this->redirectToRoute('vendeur_microservices_index', [
                'id' => $microservice->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vendeur/microservices/publication.html.twig', [
            'microservice' => $microservice,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'vendeur_microservices_show', methods: ['GET'])]
    public function show(Microservice $microservice): Response
    {
        $this->denyAccessUnlessGranted('microservice_edit', $microservice);

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

    public function getOrdre($jour){

        $ordre = 0;

        if ($jour == 'Lundi') {
            $ordre = 1;
        }elseif ($jour == 'Mardi') {
            $ordre = 2;
        }elseif ($jour == 'Mercredi') {
            $ordre = 3;
        }elseif ($jour == 'Jeudi') {
            $ordre = 4;
        }elseif ($jour == 'Vendredi') {
            $ordre = 5;
        }elseif ($jour == 'Samedi') {
            $ordre = 6;
        }elseif ($jour == 'Dimanche') {
            $ordre = 7;
        }

        return $ordre;
    }
}
