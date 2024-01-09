<?php

namespace App\Controller\CGU;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionLegalesController extends AbstractController
{
    /**
     * @Route("CGU/mentions-legales", name="mentions_legales")
     */
    public function index(): Response
    {
        $currentPage = 'Mentions Legales';
        return $this->render('CGU/mentions_legales.html.twig', [
            'currentPage' => $currentPage
        ]);
    }
}

