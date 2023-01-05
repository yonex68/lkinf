<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-utilisateur')]
class EspaceUtilisateurController extends AbstractController
{
    #[Route('/', name: 'user_profil')]
    public function profil(): Response
    {
        return $this->render('espace_utilisateur/profil.html.twig', [
            
        ]);
    }

    #[Route('/modifier-votre-mot-de-passe', name: 'edit_password', methods: ['GET', 'POST'])]
    public function editPassword(
        Request $request, UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->getUser();

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Encode(hash) the plain password, and set it.
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->flush();

            // The session is cleaned up after the password has been changed.
            //$this->cleanSessionAfterReset();

            $this->addFlash('success', 'Mot de passe modifer avec succès essayer votre nouveau mot de passe');

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('espace_utilisateur/edit_password.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

    #[Route('/modifier-votre-profil', name: 'user_edit_profil', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', "Votre compte a bien été mise à jour");

            return $this->redirectToRoute('user_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('espace_utilisateur/edit_profil.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
