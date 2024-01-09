<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $currentPage = 'Contact';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez ici les données du formulaire (par exemple, envoyez un e-mail)

            // Redirigez l'utilisateur vers une page de confirmation
            return $this->redirectToRoute('confirmationContact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'currentPage' => $currentPage,
        ]);
    }
}


//envoye de messages contact sur la boite email de l'entreprise
// class ContactController extends AbstractController
// {
//     /**
//      * @Route("/contact", name="app_contact")
//      */
//     public function index(Request $request, MailerInterface $mailer): Response
//     {
//         $form = $this->createForm(ContactType::class);

//         $form->handleRequest($request);
//         if ($form->isSubmitted() && $form->isValid()) {
//             $data = $form->getData();

//             $email = (new Email())
//                 ->from($data['email'])
//                 ->to('contact@rouenbiomonde.fr')
//                 ->subject('Nouveau message de contact')
//                 ->text($data['message']);

//             $mailer->send($email);

//             // Redirigez l'utilisateur vers une page de confirmation
//             return $this->redirectToRoute('confirmationContact');
//         }

//         return $this->render('contact/index.html.twig', [
//             'form' => $form->createView(),
//         ]);
//     }
// }
