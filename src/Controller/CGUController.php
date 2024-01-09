<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CGUController extends AbstractController
{
    /**
     * @Route("/CGU/mentions-legales", name="mentions_legales")
     */
    public function mentionsLegales(): Response
    {

        return $this->render('CGU/mentions_legales.html.twig');
    }
    /**
     * @Route("/CGU/conditions-utilisation", name="conditions_utilisation")
     */
    public function conditionsUtilisation(): Response
    {

        return $this->render('CGU/conditions_utilisation.html.twig');
    }
    /**
     * @Route("/CGU/gestion-cookies", name="gestion_cookies")
     */
    public function gestionCookies(): Response
    {

        return $this->render('CGU/gestion_cookies.html.twig');
    }
}