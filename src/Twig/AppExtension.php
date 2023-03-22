<?php

namespace App\Twig;

use App\Repository\AbonnementRepository;
use App\Repository\AvisRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\ConversationRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\PortefeuilleRepository;
use App\Repository\SuivisRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $categorieRepositorye;

    private $abonnementRepository;

    private $portefeuilleRepository;

    private $avisRepository;

    private $conversationRepository;

    private $commandeRepository;

    private $suivisRepository;

    private $microserviceRepository;

    public function __construct(CategorieRepository $categorieRepositorye, AbonnementRepository $abonnementRepository, PortefeuilleRepository $portefeuilleRepository, AvisRepository $avisRepository, ConversationRepository $conversationRepository, CommandeRepository $commandeRepository, SuivisRepository $suivisRepository, MicroserviceRepository $microserviceRepository){

        $this->abonnementRepository = $abonnementRepository;
        $this->categorieRepositorye = $categorieRepositorye;
        $this->portefeuilleRepository = $portefeuilleRepository;
        $this->avisRepository = $avisRepository;
        $this->conversationRepository = $conversationRepository;
        $this->commandeRepository = $commandeRepository;
        $this->suivisRepository = $suivisRepository;
        $this->microserviceRepository = $microserviceRepository;

    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('categories', [$this, 'getCategories']),
            new TwigFunction('abonnement', [$this, 'getVendeurAbonnement']),
            new TwigFunction('portefeuille', [$this, 'getVendeurPortefeuille']),
            new TwigFunction('avispositif', [$this, 'getVendeurAvisPositif']),
            new TwigFunction('avisnegatif', [$this, 'getVendeurAvisNegatif']),
            new TwigFunction('getMessageNonLu', [$this, 'getMessageNonLu']),
            new TwigFunction('getCommandeNonLu', [$this, 'getCommandeNonLu']),
            new TwigFunction('followers', [$this, 'getVendeurFollowers']),
            new TwigFunction('serviceAvis', [$this, 'getServicesAvisPositif']),
            new TwigFunction('serviceCommandes', [$this, 'getServicesCommandes']),
            new TwigFunction('lastedServices', [$this, 'getLastServices']),
            new TwigFunction('ventes', [$this, 'getVendeurTotalVente']),
            new TwigFunction('commandeEncours', [$this, 'getVendeurCommandesEncours']),
        ];
    }

    public function getCategories(){
        return $this->categorieRepositorye->findAll([], ['name' => 'ASC']);
    }

    public function getVendeurAbonnement($vendeur){
        return $this->abonnementRepository->findOneBy(['user' => $vendeur]);
    }

    public function getVendeurPortefeuille($vendeur){
        return $this->portefeuilleRepository->findOneBy(['vendeur' => $vendeur]);
    }

    public function getVendeurAvisPositif($vendeur){
        return $this->avisRepository->findOneBy(['vendeur' => $vendeur, 'type' => 'Positif']);
    }

    public function getVendeurAvisNegatif($vendeur){
        return $this->avisRepository->findOneBy(['vendeur' => $vendeur, 'type' => 'Negatif']);
    }

    public function getVendeurFollowers($vendeur){
        return $this->suivisRepository->findBy(['vendeur' => $vendeur], ['created' => 'DESC'], 12);
    }
    
    public function getMessageNonLu($user) {
        return $this->conversationRepository->findByParticipationNonLu($user);
    }
    
    public function getCommandeNonLu($user) {
        return $this->commandeRepository->findBy(['destinataire' => $user, 'lu' => 0]);
    }
    
    public function getVendeurTotalVente($user) {
        return $this->commandeRepository->findBy(['vendeur' => $user, 'statut' => 'Livrer']);
    }
    
    public function getVendeurCommandesEncours($user) {
        return $this->commandeRepository->findBy(['vendeur' => $user, 'statut' => 'Valider']);
    }

    public function getServicesAvisPositif($service){
        return count($this->avisRepository->findBy(['microservice' => $service, 'type' => 'Positif']));
    }

    public function getServicesCommandes($service){
        return $this->commandeRepository->findBy(['microservice' => $service]);
    }

    public function getLastServices(){
        return $this->microserviceRepository->findLasted();
    }
}
