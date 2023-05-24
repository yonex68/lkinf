<?php

namespace App\Controller;

use App\Entity\SearchService;
use App\Form\HomeServiceType;
use App\Repository\CategorieRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil', methods: ['POST', 'GET'])]
    public function index(MicroserviceRepository $microserviceRepository, UserRepository $userRepository, CategorieRepository $categorieRepository, Request $request, OffreRepository $offreRepository): Response
    {
        $user = $this->getUser();
        $services = $microserviceRepository->findBy(['online' => 1], ['created' => 'DESC'], 8);
        $servicesBloc2 = null;

        if (count($services) == 8) {
            $servicesBloc2 = $microserviceRepository->findSecondLine($services[7]->getId());
        }

        $prestataires = $userRepository->findBy(['compte' => 'vendeur'], ['created' => 'DESC'], 6);
        $ville = isset($_COOKIE['LINKS-VILLE']) ? $_COOKIE['LINKS-VILLE'] : '';

        $service = new SearchService();
        $form = $this->createForm(HomeServiceType::class, $service, [
            'action' => $this->generateUrl('accueil'),
            'method' => 'POST',
        ]);

        if (isset($_COOKIE['LINKS-VILLE']) && !empty($_COOKIE['LINKS-VILLE'])) {
            $ville == $_COOKIE['LINKS-VILLE'];
            $service->setQ($ville);
        }

        if (isset($_POST) && !empty($_POST)) {

            $adresse = $_POST['adresse'];
            $ville = $_POST['ville'];

            if (empty($ville)) {
                $ville = $adresse;
            }

            setcookie('LINKS-VILLE', $ville, time()+31556926 , "/", "",  0);

            $services = $microserviceRepository->findBylocation($ville);
            
            if (count($services) == 8) {
                $servicesBloc2 = $microserviceRepository->findBloc2Bylocation($services[7]->getId(), $ville);
            }
            $prestataires = $userRepository->findBy(['compte' => 'Vendeur', 'ville' => $ville]);
        }elseif(!empty($ville)){
            $services = $microserviceRepository->findBylocation($ville);
            
            if (count($services) == 8) {
                $servicesBloc2 = $microserviceRepository->findSecondLine($services[7]->getId());
            }

            $prestataires = $userRepository->findByVille($ville);
        }

        $microservices = $services;
        $vendeurs = $prestataires;

        return $this->render('accueil/index.html.twig', [
            'microservices' => $microservices,
            'vendeurs' => $vendeurs,
            'servicesBloc2' => $servicesBloc2,
            'form' => $form->createView(),
            'ville' => $ville,
            'packs' => $offreRepository->findBy(['online' => 1], ['created' => 'DESC']),
            'categories' => $categorieRepository->findBy([], ['position' => 'ASC'], 6)
        ]);
    }
}
