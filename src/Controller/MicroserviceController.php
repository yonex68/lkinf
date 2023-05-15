<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Microservice;
use App\Entity\SearchService;
use App\Entity\ServiceOption;
use App\Entity\ServiceSignale;
use App\Form\Commande2Type;
use App\Form\CommandeType;
use App\Form\SearchServiceType;
use App\Form\ServiceSignaleType;
use App\Repository\AvisRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\DisponibiliteRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\OffreRepository;
use App\Repository\ServiceOptionRepository;
use App\Repository\ServiceSignaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/microservices')]
class MicroserviceController extends AbstractController
{
    #[Route('/', name: 'microservices', methods: ['GET', 'POST'])]
    public function index(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request, CategorieRepository $categorieRepository, OffreRepository $offreRepository): Response
    {
        $search = new SearchService();
        $search->page = $request->get('page', 1);
        $ville = isset($_COOKIE['LINKS-VILLE']) ? $_COOKIE['LINKS-VILLE'] : '';
        $search->setVille($ville);
        $form = $this->createForm(SearchServiceType::class, $search);
        $form->handleRequest($request);

        $microservices = $microserviceRepository->findSearch($search);
        $categories = $categorieRepository->findBy([], ['created' => 'DESC']);

        if ($request->get('ajax')) {

            return new JsonResponse([
                'content' => $this->renderView('microservice/composants/_listing.html.twig', ['microservices' => $microservices]),
                /*'sorting' => $this->renderView('microservice/composants/_sorting.html.twig', ['microservices' => $microservices]),*/
                'form' => $this->renderView('microservice/composants/_search_form.html.twig', ['microservices' => $microservices, 'form' => $form->createView()]),
                'pagination' => $this->renderView('microservice/composants/_pagination.html.twig', ['microservices' => $microservices]),
            ]);
        }

        return $this->renderForm('microservice/index.html.twig', [
            'microservices' => $microservices,
            'categories' => $categories,
            'form' => $form,
            'ville' => $ville,
            'query' => $search->q,
            'packs' => $offreRepository->findBy(['online' => 1], ['created' => 'DESC']),
        ]);
    }

    #[Route('/categories/{slug}', name: 'microservices_categories', methods: ['GET', 'POST'])]
    public function categories(MicroserviceRepository $microserviceRepository, PaginatorInterface $paginator, Request $request, CategorieRepository $categorieRepository, $slug): Response
    {
        $search = new SearchService();
        $search->page = $request->get('page', 1);
        $ville = isset($_COOKIE['LINKS-VILLE']) ? $_COOKIE['LINKS-VILLE'] : '';
        $search->setVille($ville);
        $form = $this->createForm(SearchServiceType::class, $search);
        $form->handleRequest($request);

        $microservices = $microserviceRepository->findSearch($search);
        $categories = $categorieRepository->findBy([], ['created' => 'DESC']);

        if ($request->get('ajax')) {

            return new JsonResponse([
                'content' => $this->renderView('microservice/composants/_listing.html.twig', ['microservices' => $microservices]),
                /*'sorting' => $this->renderView('microservice/composants/_sorting.html.twig', ['microservices' => $microservices]),*/
                'form' => $this->renderView('microservice/composants/_search_form.html.twig', ['microservices' => $microservices, 'form' => $form->createView()]),
                'pagination' => $this->renderView('microservice/composants/_pagination.html.twig', ['microservices' => $microservices]),
            ]);
        }

        return $this->renderForm('microservice/categories.html.twig', [
            'microservices' => $microservices,
            'categories' => $categories,
            'ville' => $ville,
            'form' => $form,
            'categorie' => $categorieRepository->findOneBy(['slug' => $slug]),
        ]);
    }

    #[Route('/{slug}', name: 'microservice_details', methods: ['GET', 'POST'])]
    public function details(Microservice $microservice, Request $request, EntityManagerInterface $entityManager, MicroserviceRepository $microserviceRepository, AvisRepository $avisRepository, ServiceOptionRepository $serviceOptionRepository, ServiceSignaleRepository $serviceSignaleRepository, DisponibiliteRepository $disponibiliteRepository, CommandeRepository $commandeRepository): Response
    {

        $similaires = $microserviceRepository->findBy(['vendeur' => $this->getUser()], ['created' => 'DESC'], 12);
        /** @var ServiceOption $option */
        $options = $microservice->getServiceOptions();
        $categories = ['Ingenieur son', 'Studio'];
        $isHiden = null;
        $tauxHoraire = '';

        $erreurmessage = '';

        $serviceSignale = new ServiceSignale();
        $servicesignaleForm = $this->createForm(ServiceSignaleType::class, $serviceSignale);
        $servicesignaleForm->handleRequest($request);

        if ($servicesignaleForm->isSubmitted() && $servicesignaleForm->isValid()) {

            $serviceSignale->setUser($this->getUser());
            $serviceSignale->setMicroservice($microservice);
            $serviceSignaleRepository->save($serviceSignale, true);
            $this->addFlash('success', 'Le service à bien été signalé merci pour votre collaboration');

            return $this->redirectToRoute('microservice_details', [
                'slug' => $microservice->getSlug()
            ], Response::HTTP_SEE_OTHER);

            $this->addFlash('success', 'le contenu a bien été enregistré');
        }

        if (in_array($microservice->getCategorie(), $categories)) {
            
            $commandeFormType = CommandeType::class; 
        }else {
            $commandeFormType = Commande2Type::class;
            $isHiden = true;
        }

        $commande = new Commande();
        $commandeForm = $this->createForm($commandeFormType, $commande);
        $commandeForm->handleRequest($request);

        if ($commandeForm->isSubmitted() && $commandeForm->isValid()) {

            /** Traitement pour cette catégorie */
            if (in_array($microservice->getCategorie(), $categories)) {

                $reservationDate = $commandeForm->get('reservationDate')->getData();
                $reservationStart = $commandeForm->get('reservationStartAt')->getData();
                $reservationEnd = $commandeForm->get('reservationEndAt')->getData();
                $tauxHoraire = date_diff($reservationEnd, $reservationStart);

                /** @var Commande $reservation Verification de l"existatnce de la resvation */
                $reservation = $commandeRepository->findOneBy([
                    'reservationDate' => $reservationDate,
                    'vendeur' => $microservice->getVendeur()
                ]);

                if ($reservation) {

                    $heureDebutReservee = date_format($reservation->getReservationStartAt(), 'H');
                    $heureFinReservee = date_format($reservation->getReservationEndAt(), 'H');
                    $newReservationStart = date_format($reservationStart, 'H');
                    $newReservationEnd = date_format($reservationEnd, 'H');

                    if ($newReservationStart == $heureDebutReservee) {

                        $dateconv = strtotime($reservationDate);
                        $date = date('d/m/Y', $dateconv);

                        /** Injection de l'erreur */
                        $erreurmessage = "Ce prestataire a déjà une reservation ce $date à partir de $heureDebutReservee" . 'h';

                        //dd("Ce prestataire a déjà une reservation ce $date à partir de $heureDebutReservee" . 'h');
                    }
                }

                if ($microservice->getCategorie() == 'Ingenieur son' && $tauxHoraire < 2) {
                    $erreurmessage = "Le taux horaire minimal pour un ingenieur de son est de 2heure, de $reservationStart  à $reservationEnd fait $tauxHoraire h";
                }
            }

            /** S'il y a une reservation relative, on notifi l'utilisateur */
            if ($erreurmessage) {
                $this->addFlash('warning', $erreurmessage);
            } else {
                $commande->setMicroservice($microservice);
                //$commande->setDisponibilite($disponibilite);
                //$commande->setPaymentIntent();
                $commande->setClient($this->getUser());
                $commande->setVendeur($microservice->getVendeur());

                if (in_array($microservice->getCategorie(), $categories))
                    $commande->setTauxHoraire($tauxHoraire);

                $commande->setDestinataire($microservice->getVendeur());
                $commande->setConfirmationClient(false);
                $commande->setLu(false);
                $commande->setStatut('Non payée');
                $commande->setOffre('Reservation');
                $commande->setValidate(false);
                $commande->setDeliver(false);
                $commande->setCancel(false);
                $entityManager->persist($commande);
                $entityManager->flush();

                return $this->redirectToRoute('commander_microservice_reservation', [
                    'slug' => $microservice->getSlug(),
                    'commande' => $commande->getId(),
                ]);
            }
        }

        return $this->render('microservice/details.html.twig', [
            'microservice' => $microservice,
            'similaires' => $similaires,
            'servicesignaleForm' => $servicesignaleForm->createView(),
            'commandeForm' => $commandeForm->createView(),
            'prix' => $microservice->getPrix(),
            'options' => $options,
            'isHiden' => $isHiden,
            'erreurmessage' => $erreurmessage,
            'avisPositifs' => $avisRepository->findOneBy(['microservice' => $microservice, 'type' => 'Positif']),
            'disponibilites' => $disponibiliteRepository->findBy(['service' => $microservice], ['created' => 'ASC']),
        ]);
    }
}
