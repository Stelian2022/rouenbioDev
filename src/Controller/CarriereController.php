<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarriereController extends AbstractController
{
    #[Route('/carriere', name: 'app_carriere')]
    public function index(): Response
    {
        $currentPage = 'Carrière';
        return $this->render('carriere/index.html.twig', [
            'currentPage' => $currentPage,
        ]);
    }
    
    
}
