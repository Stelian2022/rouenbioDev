<?php

namespace App\Controller;

use App\Form\DeliveryZoneFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class Livraison extends AbstractController
{
    #[Route('/livraison', name: 'livraison')]
    public function checkDeliveryZone(Request $request)
    {
        $form = $this->createForm(DeliveryZoneFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userPostalCode = $form->get('postal_code')->getData();
            $deliveryZones = $this->getParameter('delivery_zones');
            $inDeliveryZone = in_array($userPostalCode, $deliveryZones);

            $message = $inDeliveryZone ? 'La livraison est disponible dans votre commune.' : 'Malheureusement, la livraison n\'est pas disponible dans votre commune.';
            $currentPage = 'Livraison';
            return $this->render('livraison/result.html.twig', [
                'message' => $message,
                'currentPage' => $currentPage
            ]);
        }
        $currentPage = 'Livraison';
        return $this->render('livraison/index.html.twig', [
            'form' => $form->createView(),

            'currentPage' => $currentPage
        ]);
    }
}
