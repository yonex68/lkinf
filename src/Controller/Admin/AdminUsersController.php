<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminEditUserType;
use App\Form\UserType;
use App\Repository\MicroserviceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/users')]
class AdminUsersController extends AbstractController
{
    private $sluger;

    public function __construct(SluggerInterface $sluger)
    {
        $this->sluger = $sluger;
    }

    #[Route('/', name: 'app_admin_users_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $userRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/admin_users/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/clients', name: 'app_admin_users_client', methods: ['GET'])]
    public function clients(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $userRepository->findByRole('ROLE_CLIENT'),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/admin_users/client.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/vendeurs', name: 'app_admin_users_vendeur', methods: ['GET'])]
    public function vendeurs(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $userRepository->findByRole('ROLE_VENDEUR'),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/admin_users/vendeur.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/administrateurs', name: 'app_admin_users_admin', methods: ['GET'])]
    public function administrateur(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $userRepository->findByRole('ROLE_ADMIN'),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/admin_users/admin.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/ajouter', name: 'app_admin_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
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
            $user->setCompte('Administrateur');

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Compte ' . $user->getCompte() . ' crée avec succès');

            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profil/{nameUrl}', name: 'app_admin_users_show', methods: ['GET'])]
    public function show(User $user, PaginatorInterface $paginator, Request $request, MicroserviceRepository $microserviceRepository): Response
    {
        $services = $paginator->paginate(
            $microserviceRepository->findBy(['vendeur' => $user], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/admin_users/show.html.twig', [
            'user' => $user,
            'services' => $services,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_admin_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(AdminEditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            if (!empty($form->get('plainPassword')->getData())) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            $userNameUrl = $this->sluger->slug(strtolower($user->getNom() . '-' . $user->getPrenom()));

            $user->setNameUrl($userNameUrl);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Compte ' . $user->getCompte() . ' modifié avec succès');

            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_users_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            $this->addFlash('success', 'Compte ' . $user->getCompte() . ' crée avec succès');
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
