<?php

namespace App\Controller\Vendeur;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendeur/achats')]
class VendeurAchatsController extends AbstractController
{
    #[Route('/', name: 'vendeur_achats_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findBy(['client' => $this->getUser()]);

        return $this->render('vendeur/achats/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/{id}', name: 'vendeur_achats_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('vendeur/achats/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}', name: 'vendeur_achats_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
            $this->addFlash('success', 'La commande a bient été supprimée');
        }

        return $this->redirectToRoute('vendeur_achats_index', [], Response::HTTP_SEE_OTHER);
    }
}
