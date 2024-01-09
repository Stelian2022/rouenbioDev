<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionsController extends AbstractController
{
    #[Route('/promotions', name: 'app_promotions')]
    public function index(): Response
    {
        $currentPage = 'Promotions 2024';
        return $this->render('promotions/janvier.html.twig', [
            'currentPage' => $currentPage,
        ]);
    }
}