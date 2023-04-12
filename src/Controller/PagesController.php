<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pages')]
class PagesController extends AbstractController
{
    #[Route('/faqs', name: 'page_faqs')]
    public function faqs(): Response
    {
        return $this->render('pages/faqs.html.twig', [
            
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'page_politiques')]
    public function politiques(): Response
    {
        return $this->render('pages/politiques.html.twig', [
            
        ]);
    }

    #[Route('/mentions-legales', name: 'page_mentions')]
    public function mentions(): Response
    {
        return $this->render('pages/mentions.html.twig', [
            
        ]);
    }
}
