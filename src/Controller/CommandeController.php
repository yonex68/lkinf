<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Portefeuille;
use App\Repository\CommandeRepository;
use App\Repository\MicroserviceRepository;
use App\Repository\PrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\TextUI\Command;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes')]
class CommandeController extends AbstractController
{
    private $privateKey;

    //private $paypalkey;

    public function __construct()
    {
        /**
         * Vérification de l'environnement
         */
        if($_ENV['APP_ENV'] === 'dev'){

            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];

            //$this->paypalkey = $_ENV['PAYPAL_SECRET_KEY_TEST'];

        }else{

            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_LIVE'];

            //$this->paypalkey = $_ENV['PAYPAL_SECRET_KEY_LIVE'];
        }
    }
    
    #[Route('/validee/commande_id={id}', name: 'commande_details')]
    public function commande(CommandeRepository $commandeRepository, $id): Response
    {
        $commande = $commandeRepository->find($id);

        $particlipants = [$commande->getClient(), $commande->getVendeur()];

        if(!in_array($this->getUser(), $particlipants)){
            dd('Accès non autorisé');
        }

        return $this->render('commande/validee.html.twig', [
            'commande' => $commande
        ]);
    }
    
    #[Route('/success', name: 'commande_success')]
    public function success(): Response
    {
        return $this->render('commande/success.html.twig', [
            
        ]);
    }

    #[Route('/{slug}/{offre}', name: 'commander_microservice', methods: ['GET', 'POST'])]
    public function checkout(Request $request, EntityManagerInterface $entityManager, CommandeRepository $commandeRepository, MicroserviceRepository $microserviceRepository, PrixRepository $prixRepository, $slug, $offre): Response
    {
        $microservice = $microserviceRepository->findOneBy(['slug' => $slug]);

        $prix =  $microservice->getPrix(); //$prixRepository->findOneBy(['name' => $offre, 'microservice' => $microservice]);

        foreach($prix as $price){

            if($price->getName() == $offre){
                // Affectation du montant
                $montant = $price->getTarif();
            }
        }

        $directory = $this->redirectToRoute('microservices');

        if(!$microservice){
            return $directory;
        }

        

        $portefeuille = $microservice->getVendeur()->getPortefeuille();

        if(!$portefeuille){
            $portefeuille = new Portefeuille();
            $portefeuille->setSoldeEncours(0);
            $portefeuille->setSoldeDisponible(0);
            $portefeuille->setVendeur($microservice->getVendeur());
            $entityManager->persist($portefeuille);
            $entityManager->flush();
        }

        // Calcul des taxes
        $tva = 0.2;
        $montantTva = $montant * $tva;

        // Frais bancaire
        $frais = 0.029;

        $somme = ($montantTva + $montant) * $frais;

        /*$order = [
            'purchase_units' => [[
                'description'    => 'Allbeats achats de prestation',
                'items'   =>  [
                    'name'  =>  $microservice->getName(),
                    'quatity'   =>  1,
                    'unit_amount'   =>  [
                        'value'     =>  $somme * 100,
                        'currency_code' =>  'EUR',
                    ],
                ],

                'amount'  =>  [
                    'currency_code' =>  'EUR',
                    'value'         =>  $somme * 100,
                ]
            ]]
        ];*/

        // Paypal infos
        //$userTest = 'sb-rw3oo17429039@personal.example.com';
        //$sandBoxId = $this->paypalkey;


        // Stripe payment
        if($montant > 0){

            // Instanciation Stripe
            \Stripe\Stripe::setApiKey($this->privateKey);
            
            $intent = \Stripe\PaymentIntent::create([
                'amount'    =>  $montant * 100,
                'currency'  =>  'eur',
                'payment_method_types'  =>  ['card']
            ]);
            
            // Traitement du formulaire Stripe

            if($request->getMethod() === "POST"){

                if($intent['status'] === "requires_payment_method"){
                    // TODO

                }
            }
            
            //dd($intent);
            
        }else{
            //dd('aucun prix');
        }

        return $this->render('commande/checkout.html.twig', [
            'intentSecret'    =>  $intent['client_secret'],
            'intent'    => $intent,

            'microservice' => $microservice,
            'type_offre' => $offre,
            //'form' => $form,
            'montant' => $montant,
            //'clientId' => $sandBoxId,
        ]);
    }

    #[Route('/save-commande/{slug}/{offre}', name: 'save_commande')]
    public function save(MicroserviceRepository $microserviceRepository, EntityManagerInterface $entityManager, $slug, $offre, PrixRepository $prixRepository): Response
    {
        $microservice = $microserviceRepository->findOneBy(['slug' => $slug]);

        $prix =  $microservice->getPrix(); //$prixRepository->findOneBy(['name' => $offre, 'microservice' => $microservice]);

        foreach($prix as $price){

            if($price->getName() == $offre){
                // Affectation du montant
                $montant = $price->getTarif();
            }
        }

        $commande = new Commande();
        $commande->setMicroservice($microservice);
        $commande->setClient($this->getUser());
        $commande->setVendeur($microservice->getVendeur());

        $commande->setMontant($montant);
        $commande->setOffre($offre);
        $commande->setValidate(false);
        $commande->setDeliver(false);
        $commande->setCancel(false);

        $entityManager->persist($commande);
        $entityManager->flush();

        return $this->redirectToRoute('commande_success', [
            'id' => $commande->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/vendeur/commande/validate/{id}', name: 'vendeur_valider_commande', methods: ['POST'])]
    public function vendeurValiderCommande(Request $request, CommandeRepository $commandeRepository, 
        $id, EntityManagerInterface $entityManager): Response
    {
        $commande = $commandeRepository->find($id);

        if ($this->isCsrfTokenValid('validate'.$commande->getId(), $request->request->get('_token'))) {

            $portefeuille = $commande->getVendeur()->getPortefeuille();

            $somme = $commande->getMontant() + $portefeuille->getSoldeEncours();
            $portefeuille->setSoldeEncours($somme);

            $commande->setValidate(true);
            $commande->setDeliver(false);
            $commande->setStatut('Valider');
            $commande->setCancel(false);
            $commande->setValidateAt(new \DateTimeImmutable());
            $entityManager->flush();
        }

        $this->addFlash('success', 'Commande validée!');

        return $this->redirectToRoute('commande_details', [
            'id' => $commande->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/vendeur/commande/livrer/{id}', name: 'vendeur_livrer_commande', methods: ['POST'])]
    public function vendeurLivrerCommande(Request $request, CommandeRepository $commandeRepository, 
        $id, EntityManagerInterface $entityManager, MailerInterface $mailerInterface): Response
    {
        $commande = $commandeRepository->find($id);

        if ($this->isCsrfTokenValid('livrer'.$commande->getId(), $request->request->get('_token'))) {

            $portefeuille = $commande->getVendeur()->getPortefeuille();

            $somme = $commande->getMontant() + $portefeuille->getSoldeDisponible();

            $difference = null;

            if($commande->getMontant() >= $portefeuille->getSoldeEncours()){

                $difference = $commande->getMontant() - $portefeuille->getSoldeEncours();

            }else{

                $difference = $portefeuille->getSoldeEncours() - $commande->getMontant();
            }

            $portefeuille->setSoldeDisponible($somme);
            $portefeuille->setSoldeEncours($difference);

            $commande->setDeliver(true);
            $commande->setStatut('Livrer');
            $commande->setDeliverAt(new \DateTimeImmutable());

            $entityManager->flush();

            // Envoie de mail
            $email = (new TemplatedEmail())
            ->from('links@infinity.com')
            ->to($commande->getVendeur()->getEmail())
            ->subject('LINKS INFINITY - COMMANDE LIVREE')
            ->htmlTemplate('commande/composants/_livraison_mail.html.twig')
            ->context([
                'useremail'  =>  $commande->getVendeur()->getEmail(),
                'montantRecu'   =>  $commande->getMontant(),
                'soldedispo' => $somme,
                'destinataire' => $commande->getClient()->getEmail()
            ])
            ;

            $mailerInterface->send($email);
            $commande->setDeliver(true);
            $commande->setDeliverAt(new \DateTimeImmutable());
            $entityManager->flush();
        }

        $this->addFlash('success', 'Commande validée!');

        return $this->redirectToRoute('commande_details', [
            'id' => $commande->getId(),
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/vendeur/commande/annuler/{id}', name: 'vendeur_annuler_commande', methods: ['POST'])]
    public function vendeurAnnulerCommande(Request $request, CommandeRepository $commandeRepository, 
        $id, EntityManagerInterface $entityManager): Response
    {
        $commande = $commandeRepository->find($id);

        if ($this->isCsrfTokenValid('annuler'.$commande->getId(), $request->request->get('_token'))) {

            $portefeuille = $commande->getVendeur()->getPortefeuille();

            if($commande->getMontant() >= $portefeuille->getSoldeEncours()){

                $difference = $commande->getMontant() - $portefeuille->getSoldeEncours();

            }else{

                $difference = $portefeuille->getSoldeEncours() - $commande->getMontant();
            }

            $portefeuille->setSoldeEncours($difference);

            $commande->setCancel(true);
            $commande->setStatut('Annuler');
            $commande->setDeliver(false);
            $commande->setValidate(false);
            $commande->setCancelAt(new \DateTimeImmutable());
            
            $entityManager->flush();
        }

        $this->addFlash('success', 'Commande annulée!');

        return $this->redirectToRoute('commande_details', [
            'id' => $commande->getId(),
        ], Response::HTTP_SEE_OTHER);
    }
}
