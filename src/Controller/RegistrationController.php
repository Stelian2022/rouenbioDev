<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Security\Authenticator;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    #[Route('/register', name: 'app_register')]

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, Authenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $currentPage = "Inscription";
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $greeting = 'Bonjour ' . $user->getNom() . ' ' . $user->getPrenom();

                $user->setRoles(['ROLE_USER']);
                $user->setCreatedAt(new DateTimeImmutable);
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
                // return $this->redirectToRoute('app_register');

                return $userAuthenticator->authenticateUser(

                    $user,
                    $authenticator,
                    $request
                );
            } else {
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                    'passError' => 'Les mots de pass ne sont pas identiques'
                ]);
            }
        }


        return $this->render('registration/register.html.twig', [

            'registrationForm' => $form->createView(),
            'currentPage' => $currentPage,
        ]);
    }
}
