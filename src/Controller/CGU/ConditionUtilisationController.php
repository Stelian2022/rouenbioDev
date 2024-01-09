<?php

namespace App\Controller\CGU;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionUtilisationController extends AbstractController
{
    /**
     * @Route("CGU/conditions-utilisation", name="conditions_utilisation")
     */
    public function index(): Response
    {
        $currentPage = 'Conditions Utilisation';
        return $this->render('CGU/conditions_utilisation.html.twig', [
            'currentPage' => $currentPage
        ]);
    }
}
