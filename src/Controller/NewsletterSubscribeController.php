<?php

namespace App\Controller;

use App\Entity\Newsletters;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;


class NewsletterSubscribeController extends AbstractController
{
   /**
 * @Route("/newsletter_subscribe", name="newsletter_subscrib", methods={"POST"})
 */
public function subscribe(Request $request, EntityManagerInterface $entityManager): Response
{
    $email = $request->request->get('email');
    $currentPage = 'Newsletters';
    if (empty($email)) {
        $this->addFlash('error', 'Adresse email invalide');
        return $this->render('newsletter_subscribe/index.html.twig', [
            'currentPage' => $currentPage,

        ]); // Rendre la même page
        
    }

    // Check if the email already exists in the database
    $existingEmail = $entityManager->getRepository(Newsletters::class)->findOneBy(['email' => $email]);

    if ($existingEmail) {
        // Handle the case when email already exists
        // You can display a popup message or any other logic here
        $this->addFlash('warning', 'L adresse email est deja inregistré');
        $request->getSession()->set('subscribed', true); // Set session variable to prevent popup
        return $this->render('newsletter_subscribe/index.html.twig'); // Rendre la même page
    }

    // Create a new instance of the Newsletters entity
    $newsletter = new Newsletters();

    // Make sure $email is not null before calling setEmail
    if ($email !== null) {
        $newsletter->setEmail($email);
    }

    // Persist the entity to the database
    $entityManager->persist($newsletter);
    $entityManager->flush();

    // Optionally, you can add some success flash message
    $this->addFlash('success', 'You have successfully subscribed to the newsletter.');
    $request->getSession()->set('subscribed', true);

    // Redirect the user to a confirmation page or any other relevant page
    return $this->render('newsletter_subscribe/index.html.twig');
}

}
