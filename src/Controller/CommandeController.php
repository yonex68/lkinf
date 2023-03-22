<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Commande;
use App\Entity\CommandeMessage;
use App\Entity\Message;
use App\Entity\Portefeuille;
use App\Form\AvisType;
use App\Form\CommandeMessageType;
use App\Repository\CommandeMessageRepository;
use App\Repository\CommandeRepository;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
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

    #[Route('/chat', name: 'commandes_chats')]
    public function chat(CommandeRepository $commandeRepository): Response
    {
        $user = $this->getUser();

        $commandes = $commandeRepository->findWhereUserIsClientOrVendeur($user);

        return $this->render('commande/chat.html.twig', [
            'usercommandes' => $commandes,
        ]);
    }

    #[Route('/validee/commande_id={id}', name: 'commande_details')]
    public function commande(CommandeRepository $commandeRepository, $id, Request $request, EntityManagerInterface $entityManager, CommandeMessageRepository $commandeMessageRepository): Response
    {
        $user = $this->getUser();
        $commande = $commandeRepository->find($id);

        $redirect = $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);

        if (!$commande) {
            return $redirect;
        }

        // Les participants de la conversation
        $particlipants = [$commande->getClient(), $commande->getVendeur()];

        if (!in_array($user, $particlipants)) {
            return $redirect;
        }

        if ($commande->getDestinataire()->getId() == $user->getId() && $commande->getLu() == 0) {
            $commande->setLu(true);
            $entityManager->flush();
        }

        // Recupération des commandes de cet utilisateur
        $usercommandes = $commandeRepository->findWhereUserIsClientOrVendeur($user);

        // Recupération des méssages liés à cette commande
        $messages = $commandeMessageRepository->findBy([
            'commande' => $commande
        ]);

        $avis = new Avis();
        $avisForm = $this->createForm(AvisType::class, $avis);
        $avisForm->handleRequest($request);

        if ($avisForm->isSubmitted() && $avisForm->isValid()) {

            $avis->setVendeur($commande->getMicroservice()->getVendeur());
            $avis->setMicroservice($commande->getMicroservice());
            $avis->setClient($user);
            $entityManager->persist($avis);
            $entityManager->flush();

            $this->addFlash('success', "Votre avis à bien été soumis");

            return $this->redirectToRoute('commande_details', [
                'id' => $commande->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        // Test de message
        $message = new CommandeMessage();
        $form = $this->createForm(CommandeMessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $destinataire = null;

            if ($user->getId() == $commande->getVendeur()->getId()) {
                $destinataire = $commande->getClient();
            } else {
                $destinataire = $commande->getVendeur();
            }

            $commande->setDestinataire($destinataire);
            $commande->setLu(false);
            
            $message->setCommande($commande);
            $message->setUser($this->getUser());
            $message->setLu(false);
            $entityManager->persist($message);
            $entityManager->flush();


            return $this->redirectToRoute('commande_details', [
                'id' => $commande->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/validee.html.twig', [
            'commande' => $commande,
            'avisForm' => $avisForm->createView(),
            'usercommandes' => $usercommandes,
            'messages' => $messages,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/success', name: 'commande_success')]
    public function success(): Response
    {
        return $this->render('commande/success.html.twig', []);
    }

    #[Route('/{slug}/{offre}', name: 'commander_microservice', methods: ['GET', 'POST'])]
    public function checkout(Request $request, EntityManagerInterface $entityManager, CommandeRepository $commandeRepository, MicroserviceRepository $microserviceRepository, PrixRepository $prixRepository, $slug, $offre): Response
    {
        $microservice = $microserviceRepository->findOneBy(['slug' => $slug]);

        $montant = null;

        if ($offre == 'Mastering') {
            $montant = $microservice->getPrixMastering();
        }elseif($offre == 'Mixage'){
            $montant = $microservice->getPrixMixage();
        }elseif($offre == 'Beatmaking'){
            $montant = $microservice->getPrixBeatmaking();
        }

        $directory = $this->redirectToRoute('microservices');

        if (!$microservice) {
            return $directory;
        }

        $portefeuille = $microservice->getVendeur()->getPortefeuille();

        if (!$portefeuille) {
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

        $order = [
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

            if ($request->getMethod() === "POST") {

                if ($intent['status'] === "requires_payment_method") {
                    // TODO

                }
            }

            //dd($intent);

        } else {
            //dd('aucun prix');
        }

        return $this->render('commande/checkout.html.twig', [
            'intentSecret'    =>  $intent['client_secret'],
            'intent'    => $intent,

            'microservice' => $microservice,
            'type_offre' => $offre,
            'montant' => $montant,
            'clientId' => $sandBoxId,
        ]);
    }

    #[Route('/save-commande/{slug}/{offre}', name: 'save_commande')]
    public function save(MicroserviceRepository $microserviceRepository, EntityManagerInterface $entityManager, $slug, $offre, PrixRepository $prixRepository): Response
    {
        $microservice = $microserviceRepository->findOneBy(['slug' => $slug]);

        $montant = null;

        if ($offre == 'Mastering') {
            $montant = $microservice->getPrixMastering();
        }elseif($offre == 'Mixage'){
            $montant = $microservice->getPrixMixage();
        }elseif($offre == 'Beatmaking'){
            $montant = $microservice->getPrixBeatmaking();
        }else {
            $montant = $microservice->getPrixComposition();
        }

        $commande = new Commande();
        $commande->setMicroservice($microservice);
        $commande->setClient($this->getUser());
        $commande->setVendeur($microservice->getVendeur());
        $commande->setDestinataire($microservice->getVendeur());
        $commande->setConfirmationClient(false);
        $commande->setLu(false);
        $commande->setStatut('En attente');

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
    public function vendeurValiderCommande(
        Request $request,
        CommandeRepository $commandeRepository,
        $id,
        EntityManagerInterface $entityManager
    ): Response {
        $commande = $commandeRepository->find($id);

        if ($this->isCsrfTokenValid('validate' . $commande->getId(), $request->request->get('_token'))) {

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
    public function vendeurLivrerCommande(
        Request $request,
        CommandeRepository $commandeRepository,
        $id,
        EntityManagerInterface $entityManager,
        MailerInterface $mailerInterface
    ): Response {
        $commande = $commandeRepository->find($id);

        if ($this->isCsrfTokenValid('livrer' . $commande->getId(), $request->request->get('_token'))) {

            $portefeuille = $commande->getVendeur()->getPortefeuille();

            //dd($conversation);

            $somme = $commande->getMontant() + $portefeuille->getSoldeDisponible();

            $difference = null;

            if ($commande->getMontant() >= $portefeuille->getSoldeEncours()) {

                $difference = $commande->getMontant() - $portefeuille->getSoldeEncours();
            } else {

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
                ]);

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
    public function vendeurAnnulerCommande(
        Request $request,
        CommandeRepository $commandeRepository,
        $id,
        EntityManagerInterface $entityManager
    ): Response {
        $commande = $commandeRepository->find($id);

        if ($this->isCsrfTokenValid('annuler' . $commande->getId(), $request->request->get('_token'))) {

            $portefeuille = $commande->getVendeur()->getPortefeuille();

            if ($commande->getMontant() >= $portefeuille->getSoldeEncours()) {

                $difference = $commande->getMontant() - $portefeuille->getSoldeEncours();
            } else {

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
