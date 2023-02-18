<?php

namespace App\Twig;

use App\Repository\AbonnementRepository;
use App\Repository\AvisRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\ConversationRepository;
use App\Repository\PortefeuilleRepository;
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

    public function __construct(CategorieRepository $categorieRepositorye, AbonnementRepository $abonnementRepository, PortefeuilleRepository $portefeuilleRepository, AvisRepository $avisRepository, ConversationRepository $conversationRepository, CommandeRepository $commandeRepository){

        $this->abonnementRepository = $abonnementRepository;
        $this->categorieRepositorye = $categorieRepositorye;
        $this->portefeuilleRepository = $portefeuilleRepository;
        $this->avisRepository = $avisRepository;
        $this->conversationRepository = $conversationRepository;
        $this->commandeRepository = $commandeRepository;

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
    
    public function getMessageNonLu($user) {
        return $this->conversationRepository->findByParticipationNonLu($user);
    }
    
    public function getCommandeNonLu($user) {
        return $this->commandeRepository->findBy(['destinataire' => $user, 'lu' => 0]);
    }
}
