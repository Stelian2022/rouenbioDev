<?php

namespace App\Controller\CGU;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCookiesController extends AbstractController
{
    /**
     * @Route("CGU/gestion-cookies", name="gestion_cookies")
     */
    public function index(): Response
    {
        $currentPage = 'Gestion Cookies';
        return $this->render('CGU/gestion_cookies.html.twig', [
            'currentPage' => $currentPage
        ]);
    }
}
