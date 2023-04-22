<?php

namespace App\Controller;

use App\Entity\Portefeuille;
use App\Entity\User;
use App\Form\DevenirVendeurType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    private $sluger;

    public function __construct(EmailVerifier $emailVerifier, SluggerInterface $sluger)
    {
        $this->emailVerifier = $emailVerifier;
        $this->sluger = $sluger;
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $userNameUrl = $this->sluger->slug(strtolower($user->getNom() . '-' . $user->getPrenom()));

            $user->setNameUrl($userNameUrl);
            //$user->setIsLocked(false);

            if ($form->get('compte')->getData() == 'Vendeur') {

                $user->setRoles(['ROLE_VENDEUR']);
                $user->setCompte('Vendeur');

                // Création du portefeuille si l'utilisateur choisis le compte vendeur
                $portefeuille = new Portefeuille();
                $portefeuille->setSoldeDisponible(0);
                $portefeuille->setSoldeEncours(0);
                $portefeuille->setVendeur($user);

                $entityManager->persist($portefeuille);

                $route = 'user_categorie';

            } elseif ($form->get('compte')->getData() == 'Client') {

                $route = 'register_mail_send';

                $user->setRoles(['ROLE_CLIENT']);
                $user->setCompte('Client');
            }

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('contact@links-infinity.com', 'links infinity'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            return $this->redirectToRoute('app_register_mail_send', [
                'name_url' => $user->getNameUrl()
            ]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/devenir-vendeur', name: 'app_devenir_vendeur')]
    public function devenirVendeur(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerService $mailer): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(DevenirVendeurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(['ROLE_VENDEUR']);
            $user->setCompte('Vendeur');

            // Création du portefeuille si l'utilisateur choisis le compte vendeur
            $portefeuille = $user->getPortefeuille();

            if (!$portefeuille) {
                $portefeuille = new Portefeuille();
                $portefeuille->setSoldeDisponible(0);
                $portefeuille->setSoldeEncours(0);
                $portefeuille->setVendeur($user);
                $entityManager->persist($portefeuille);
            }
            $entityManager->flush();

            // generate a signed url and email it to the user
            /*$mailer->sendMailBecomeSaller(
                'contact@links-infinity.com',
                $user->getEmail(),
                'Sujet',
                'mails/_default.html.twig',
                $user,
                'message'
            );*/

            // do anything else you need here, like send an email
            $this->addFlash('success', "Félication vous êtes enfin devenu vendeur");

            return $this->redirectToRoute('user_profil', []);
        }

        return $this->render('registration/devenir_vendeur.html.twig', [
            'devenirVendeur' => $form->createView(),
        ]);
    }

    #[Route('/mail-envoye/{name_url}', name: 'app_register_mail_send')]
    public function mailEnvoyer(UserRepository $userRepository, $name_url): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        $user = $userRepository->findOneBy(['nameUrl' => $name_url]);

        if (!$user) {
            return $this->redirectToRoute('accueil');
        }

        return $this->render('registration/mail_send.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Compte activé, votre adresse email a bien été vérifiée.');

        return $this->redirectToRoute('app_register');
    }
}
