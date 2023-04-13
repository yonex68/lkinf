<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Offre;
use App\Repository\OffreRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pack')]
class PackController extends AbstractController
{
    private $privateKey;

    private $paypalkey;

    public function __construct()
    {
        /**
         * Vérification de l'environnement
         */
        if ($_ENV['APP_ENV'] === 'dev') {

            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];

            $this->paypalkey = $_ENV['PAYPAL_SECRET_KEY_TEST'];
        } else {

            $this->privateKey = $_ENV['STRIPE_SECRET_KEY_LIVE'];

            $this->paypalkey = $_ENV['PAYPAL_SECRET_KEY_LIVE'];
        }
    }
    
    #[Route('/', name: 'pack_index')]
    public function index(): Response
    {
        return $this->render('pack/index.html.twig', [
            'controller_name' => 'PackController',
        ]);
    }
    
    #[Route('/commande/{slug}', name: 'pack_commande')]
    public function commandePack(Offre $offre, Request $request): Response
    {
        $montant = $offre->getTarif();

        // Paypal infos
        $userTest = 'sb-rw3oo17429039@personal.example.com';
        $sandBoxId = $this->paypalkey;

        // Calcul des taxes
        $tva = 0.2;
        $montantTva = $montant * $tva;

        // Frais bancaire
        $frais = 0.029;

        $somme = ($montantTva + $montant) * $frais;

        $order = [
            'purchase_units' => [[
                'description'    => 'Links infinity achats de prestation',
                'items'   =>  [
                    'name'  =>  $offre->getName(),
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
        ];

        // Paypal infos
        $userTest = 'sb-rw3oo17429039@personal.example.com';
        $sandBoxId = $this->paypalkey;

        // Stripe payment
        if ($montant > 0) {

            // Instanciation Stripe
            \Stripe\Stripe::setApiKey($this->privateKey);

            $intent = \Stripe\PaymentIntent::create([
                'amount'    =>  $montant * 100,
                'currency'  =>  'eur',
                'payment_method_types'  =>  ['card']
            ]);
            // Traitement du formulaire Stripe
            //dd($intent);

            if ($request->getMethod() === "POST") {

                if ($intent['status'] === "requires_payment_method") {
                    // TODO

                }
            }
        } else {
            //dd('aucun prix');
        }

        return $this->render('pack/commande.html.twig', [
            'pack' => $offre,
            'intentSecret'    =>  $intent['client_secret'],
            'intent'    => $intent,
            'intentId'    => $intent['id'],
            'type_offre' => 'Pack produit-moi',
            'montant' => $montant,
            'clientId' => $sandBoxId,
        ]);
    }

    #[Route('/save-pack/{slug}/{payment_intent}', name: 'save_pack')]
    public function save(EntityManagerInterface $entityManager, $slug, $payment_intent, OffreRepository $offreRepository, MailerService $mailer): Response
    {
        $pack = $offreRepository->findOneBy(['slug' => $slug]);
        $commande = new Commande();
        $commande->setPaymentIntent($payment_intent);
        $commande->setClient($this->getUser());
        $commande->setPack($pack);
        $commande->setConfirmationClient(true);
        $commande->setLu(true);
        $commande->setStatut('Valider');

        $commande->setMontant($pack->getTarif());
        $commande->setOffre('Pack produit-me');
        $commande->setValidate(true);
        $commande->setDeliver(true);
        $commande->setCancel(true);

        $entityManager->persist($commande);
        $entityManager->flush();

        /** Envoie du mail au client */
        $mailer->sendPackMail(
            'contact@links-infinity.com',
            $commande->getClient()->getEmail(),
            'Nouvelle commande',
            'mails/client/_pack.html.twig',
            $commande->getClient(),
            $commande
        );

        return $this->redirectToRoute('commande_success', [
            'id' => $commande->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
