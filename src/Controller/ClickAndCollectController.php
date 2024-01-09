<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClickAndCollectController extends AbstractController
{
    #[Route('/click/and/collect', name: 'app_click_and_collect')]
    public function index(): Response
    {
        $currentPage = 'Click and Collect';
        return $this->render('click_and_collect/index.html.twig', [
            'currentPage' => $currentPage
        ]);
    }
}
