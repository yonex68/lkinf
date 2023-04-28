<?php

namespace App\Twig;

use App\Repository\AbonnementRepository;
use App\Repository\AvisRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\ConversationRepository;
use App\Repository\EmploisTempsRepository;
use App\Repository\FavorisRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\PortefeuilleRepository;
use App\Repository\RemboursementRepository;
use App\Repository\RetraitRepository;
use App\Repository\ServiceSignaleRepository;
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

    private $emploisTempsRepository;

    private $serviceSignaleRepository;

    private $remboursementRepository;

    private $retraitRepository;

    private $favorisRepository;

    public function __construct(CategorieRepository $categorieRepositorye, AbonnementRepository $abonnementRepository, PortefeuilleRepository $portefeuilleRepository, AvisRepository $avisRepository, ConversationRepository $conversationRepository, CommandeRepository $commandeRepository, SuivisRepository $suivisRepository, MicroserviceRepository $microserviceRepository, EmploisTempsRepository $emploisTempsRepository, ServiceSignaleRepository $serviceSignaleRepository
    , RemboursementRepository $remboursementRepository, RetraitRepository $retraitRepository, FavorisRepository $favorisRepository){

        $this->abonnementRepository = $abonnementRepository;
        $this->categorieRepositorye = $categorieRepositorye;
        $this->portefeuilleRepository = $portefeuilleRepository;
        $this->avisRepository = $avisRepository;
        $this->conversationRepository = $conversationRepository;
        $this->commandeRepository = $commandeRepository;
        $this->suivisRepository = $suivisRepository;
        $this->microserviceRepository = $microserviceRepository;
        $this->emploisTempsRepository = $emploisTempsRepository;
        $this->serviceSignaleRepository = $serviceSignaleRepository;
        $this->remboursementRepository = $remboursementRepository;
        $this->retraitRepository = $retraitRepository;
        $this->favorisRepository = $favorisRepository;

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
            new TwigFunction('lastFolowers', [$this, 'getVendeurlastFolowers']),
            new TwigFunction('serviceAvis', [$this, 'getServicesAvisPositif']),
            new TwigFunction('serviceCommandes', [$this, 'getServicesCommandes']),
            new TwigFunction('lastedServices', [$this, 'getLastServices']),
            new TwigFunction('ventes', [$this, 'getVendeurTotalVente']),
            new TwigFunction('commandeEncours', [$this, 'getVendeurCommandesEncours']),
            new TwigFunction('clientCommandeEncours', [$this, 'getClientCommandesEncours']),
            new TwigFunction('clientAchats', [$this, 'getClientTotalAchats']),
            new TwigFunction('serviceAvisPositifs', [$this, 'getServiceAvisPositif']),
            new TwigFunction('serviceAvisNegatifs', [$this, 'getServiceAvisNegatif']),
            new TwigFunction('emploistemps', [$this, 'getVendeurEmploisTemps']),
            new TwigFunction('alertesNonLu', [$this, 'getAlertesNonLu']),
            new TwigFunction('userRemboursements', [$this, 'getUserRemboursements']),
            new TwigFunction('truncateTitle', [$this, 'truncateTitle']),
            new TwigFunction('ville', [$this, 'getUserVille']),
            new TwigFunction('retraits', [$this, 'getVendeurRetraits']),
            new TwigFunction('clientSuivis', [$this, 'getClientSuivis']),
            new TwigFunction('clientFavoris', [$this, 'getClientFavoris']),
            new TwigFunction('clientRemboursements', [$this, 'getClientRemboursements']),
        ];
    }

    public function getCategories(){
        return $this->categorieRepositorye->findBy([], ['position' => 'ASC']);
    }

    public function getClientSuivis($client){
        return $this->suivisRepository->findBy(['client' => $client]);
    }

    public function getClientRemboursements($user){
        return $this->remboursementRepository->findBy(['user' => $user]);
    }

    public function getClientFavoris($client){
        return $this->favorisRepository->findBy(['client' => $client]);
    }

    public function getVendeurAbonnement($vendeur){
        return $this->abonnementRepository->findOneBy(['user' => $vendeur]);
    }

    public function getVendeurRetraits($vendeur){
        return $this->retraitRepository->findTotal($vendeur);
    }

    public function getVendeurPortefeuille($vendeur){
        return $this->portefeuilleRepository->findOneBy(['vendeur' => $vendeur]);
    }

    public function getVendeurAvisPositif($vendeur){
        return $this->avisRepository->findBy(['vendeur' => $vendeur, 'type' => 'Positif']);
    }

    public function getVendeurAvisNegatif($vendeur){
        return $this->avisRepository->findBy(['vendeur' => $vendeur, 'type' => 'Negatif']);
    }

    public function getServiceAvisPositif($service){
        return $this->avisRepository->findBy(['microservice' => $service, 'type' => 'Positif']);
    }

    public function getServiceAvisNegatif($service){
        return $this->avisRepository->findBy(['microservice' => $service, 'type' => 'Negatif']);
    }

    public function getVendeurFollowers($vendeur){
        return $this->suivisRepository->findBy(['vendeur' => $vendeur], ['created' => 'DESC']);
    }

    public function getVendeurlastFolowers($vendeur){
        return $this->suivisRepository->findBy(['vendeur' => $vendeur], ['created' => 'DESC'], 12);
    }
    
    public function getMessageNonLu($user) {
        return $this->conversationRepository->findByParticipationNonLu($user);
    }
    
    public function getCommandeNonLu($user) {
        return $this->commandeRepository->findBy(['destinataire' => $user, 'lu' => 0]);
    }
    
    public function getVendeurTotalVente($user) {
        return $this->commandeRepository->findBy(['vendeur' => $user, 'deliver' => true]);
    }
    
    public function getVendeurCommandesEncours($user) {
        return $this->commandeRepository->findBy(['vendeur' => $user, 'statut' => 'Valider']);
    }
    
    public function getClientTotalAchats($user) {
        return $this->commandeRepository->findBy(['client' => $user, 'statut' => 'Livrer']);
    }
    
    public function getClientCommandesEncours($user) {
        return $this->commandeRepository->findBy(['client' => $user, 'statut' => 'Valider']);
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

    public function getVendeurEmploisTemps($vendeur){
        return $this->emploisTempsRepository->findBy(['vendeur' => $vendeur], ['ordre' => 'ASC']);
    }

    public function getAlertesNonLu(){
        return $this->serviceSignaleRepository->findBy(['lu' => null], ['created' => 'DESC']);
    }

    public function getUserRemboursements($user){
        return $this->remboursementRepository->findBy(['user' => $user, 'statut' => 'En attente'], ['created' => 'DESC']);
    }

    public function truncateTitle(String $title){

        $array = explode(' ', $title);

        if (count($array) > 4) {
            $newTitle = "";
            for ($i=0; $i < 4; $i++) { 
                $newTitle = $newTitle . ' ' . $array[$i];
            }
            return $newTitle;
        }else {
            return $title;
        }
    }

    public function getUserVille()
    {
        $ville = isset($_COOKIE['LINKS-VILLE']) ? $_COOKIE['LINKS-VILLE'] : '';

        return $ville;
    }
}
