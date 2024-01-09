<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\Order;
use App\Form\CartType;
use App\Form\UserType;
use App\Manager\CartManager;
use App\Repository\UserRepository;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{

    /**
     * @var CartSessionStorage
     */

    private $security;
    private EntityManagerInterface $em;
    private $router;

    public function __construct(Security $security, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->security = $security;
        $this->em = $em;
        $this->router = $router;
    }
    // Helper function to format order items
    private function formatOrderItems($items)
    {
        $formattedItems = '';
        foreach ($items as $item) {
            $formattedItems .= 'Produit : ' . $items->getProductName() . ', Quantité : ' . $items->getQuantity() . PHP_EOL;
            // Add more details as needed
        }
        return $formattedItems;
    }
    private function sendOrderConfirmationEmail($to, $order, $user)
    {
        $subject = 'Nouvelle commande passée';

        $message = 'Une nouvelle commande a été passée.' . PHP_EOL;
        $message .= 'Numéro de commande : ' . $order->getId() . PHP_EOL;
        $message .= 'Email : ' . $order->getUserEmail() . PHP_EOL;
        $message .= 'Produits commandés : ' . $this->formatOrderItems($order->getItems()) . PHP_EOL;
        $message .= 'Nom : ' . $user->getNom() . PHP_EOL;
        $message .= 'Prénom : ' . $user->getPrenom();
        $message .= 'Téléphone : ' . $user->getTelephone() . PHP_EOL;
        $message .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $headers = 'From: contact@rouenbiomonde.fr'; // Remplacez cela par l'adresse e-mail de l'expéditeur
        $order->setUserEmail($user->getUserIdentifier());
        mail($to, $subject, $message, $headers);
    }
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartManager $cartManager, Request $request): Response
    {
        $currentPage = 'Mon Panier';
        $cart = $cartManager->getCurrentCart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTimeImmutable());
            $cartManager->save($cart);

            return $this->redirectToRoute('cart');
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'currentPage' => $currentPage,
            'form' => $form->createView()
        ]);
       
    }

    // validate click and collect
    #[Route('/cart/confirmation', name: 'confirmationDrive')]
    public function confirmation(CartManager $cartManager, EntityManagerInterface $em, Request $request, UserRepository $userRepository): Response
    {
        // Check if the user is authenticated
        $isUserAuthenticated = $this->isGranted('ROLE_USER');

        if ($isUserAuthenticated) {
            // User is authenticated
            $user = $this->getUser();
            $userIdentifier = $user->getUserIdentifier();

            // Create a new Order instance using the validateOrder() method
            $order = $this->validateOrder($userIdentifier, $user);

            // Set the status in the order
            $order->setStatus('finalized');
            $order->setLivraison('Drive');
            $order->setUserEmail($user->getUserIdentifier());



            // Persist the order entity
            $em->beginTransaction();
            try {

                // Persist and flush the order entity
                $em->persist($order);
                $em->flush();
                $cart = $cartManager->getCurrentCart();
                $cartManager->clearCart($cart); // Supprime le panier
                $em->commit();
            } catch (\Exception $e) {
                $em->rollback();
                throw $e;
            }
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
            }
            // Envoyer un e-mail de confirmation au client
            $toCustomer = $user->getUserIdentifier();
            $subjectCustomer = 'Confirmation de commande';
            $messageCustomer = 'Merci pour votre commande! Votre commande a été confirmée avec succès.';
            $headersCustomer = 'From: contact@rouenbiomonde.fr'; // Remplacez cela par l'adresse e-mail de l'expéditeur

            mail($toCustomer, $subjectCustomer, $messageCustomer, $headersCustomer);

            // Envoyer un e-mail d'alerte à l'administrateur
            $adminEmail = 'contact@rouenbiomonde.fr'; // Remplacez cela par l'adresse e-mail de l'administrateur
            $this->sendOrderConfirmationEmail($adminEmail, $order, $user);
            // ... Perform any additional operations, such as saving the order ...
            $currentPage = 'Commande finalisé';
            return $this->render('cart/confirmationDrive.html.twig', [
                'order' => $order,
                'currentPage' => $currentPage,
                'form' => $form->createView()
            ]);
        } else {
            // User is not authenticated, redirect to the login page
            return $this->redirectToRoute('app_login');
        }
    }

    // validate livraison
    #[Route('/cart/confirmationLivraison', name: 'confirmationLivraison')]
    public function confirmationLivraison(CartManager $cartManager, EntityManagerInterface $em, Request $request): Response
    {
        // Check if the user is authenticated
        $isUserAuthenticated = $this->isGranted('ROLE_USER');

        if ($isUserAuthenticated) {
            // User is authenticated
            $user = $this->getUser();
            // check if user is in the zone de livraison
            $userIdentifier = $user->getUserIdentifier();
            // $userPostalCode = $user->getCodePostale();
            // $deliveryZones = $this->getParameter('delivery_zones');
            // $inDeliveryZone = in_array($userPostalCode, $deliveryZones);
            // $message = $inDeliveryZone ? 'La livraison est disponible dans votre commune.' : 'Malheureusement, la livraison n\'est pas disponible dans votre commune.';
            // fin check if user is in the zone de livraison

            // Create a new Order instance using the validateOrder() method
            $order = $this->validateOrder($userIdentifier, $user);

            // Set the status in the order
            $order->setStatus('finalized-payed');
            $order->setLivraison('domicile');

            $order->setUserEmail($user->getUserIdentifier());



            // Persist the order entity
            $em->beginTransaction();
            try {

                // Persist and flush the order entity
                $em->persist($order);
                $em->flush();
                $cart = $cartManager->getCurrentCart();
                $cartManager->clearCart($cart); // Supprime le panier
                $em->commit();
            } catch (\Exception $e) {
                $em->rollback();
                throw $e;
            }
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
            }


            // ... Perform any additional operations, such as saving the order ...
            $currentPage = 'Commande finalisé';
            return $this->render('cart/confirmationLivraison.html.twig', [
                'order' => $order,
                'form' => $form->createView(),
                // 'message'=>$message,
                'currentPage' => $currentPage
            ]);
        } else {
            // User is not authenticated, redirect to the login page
            return $this->redirectToRoute('app_login');
        }
    }

    private function validateOrder(string $email, $user): Order
    {
        $userIdentifier = $user->getUserIdentifier();
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())

            ->setUserEmail($user->getUserIdentifier());


        if ($user !== null) {
            $user->setEmail($email);
        }

        return $order;
    }





    #[Route('/cart/checkoutDrive', name: 'checkoutDrive')]
    public function checkoutDrive(CartManager $cartManager, Request $request): Response
    {
        // Check if the user is authenticated
        $isUserAuthenticated = $this->isGranted('ROLE_USER');

        if ($isUserAuthenticated) {
            // User is authenticated
            $user = $this->getUser();
            // Create a form for the checkout using the UserCheckoutType form type
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            $cart = $cartManager->getCurrentCart();
            if ($form->isSubmitted() && $form->isValid()) {


                // Redirect the user to a confirmation or payment page
                return $this->redirectToRoute('confirmationDrive');
            }

            $cart = $cartManager->getCurrentCart();
            $currentPage = 'Verifier vos informations';
            return $this->render('cart/checkoutDrive.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
                'cart' => $cart,
                'currentPage' => $currentPage
            ]);
        } else {
            // User is not authenticated, redirect to the login page
            return $this->redirectToRoute('app_login');
        }
    }
    #[Route('/cart/checkoutLivraison', name: 'checkoutLivraison')]
    public function checkoutLivraison(CartManager $cartManager, Request $request): Response
    {
        // Check if the user is authenticated
        $isUserAuthenticated = $this->isGranted('ROLE_USER');

        if ($isUserAuthenticated) {
            // User is authenticated
            $user = $this->getUser();
            // Create a form for the checkout using the UserCheckoutType form type
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            $cart = $cartManager->getCurrentCart();
            if ($form->isSubmitted() && $form->isValid()) {


                // Redirect the user to a confirmation or payment page
                return $this->redirectToRoute('confirmationLivraison');
            }

            $cart = $cartManager->getCurrentCart();
            $currentPage = 'Verifier vos informations';
            return $this->render('cart/checkoutLivraison.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
                'cart' => $cart,
                'currentPage' => $currentPage
            ]);
        } else {
            // User is not authenticated, redirect to the login page
            return $this->redirectToRoute('app_login');
        }
    }

   

    // #[Route('/cart/create-session-stripe', name: 'payement_stripe')]
    // function stripeCheckout(CartManager $cartManager,RouterInterface $router): RedirectResponse
    // {
    //     $produitStripe = [];
    //     $isUserAuthenticated = $this->isGranted('ROLE_USER');

    //     if ($isUserAuthenticated) {
    //         $cart = $cartManager->getCurrentCart();
    //         // User is authenticated
    //         $user = $this->getUser();
    //         $userIdentifier = $user->getUserIdentifier();
    //         $order = $this->validateOrder($userIdentifier, $user);
    //         $order->setUserEmail($user->getUserIdentifier());
    //         if (!$cart) {
    //             return $this->redirectToRoute('cart');
    //         }
    //         foreach ($cart as $produit) {

    // $produitStripe[] = [
    //     'price_data' => [
    //         'currency' => 'eur',
    //         'unit_amount' => $this->$order->getTotal(),
    //         'product_data' => [

    //             'name' => $this->$order->getItems(),
    //         ]
    //     ]
    //     'quantity' => $produit->getQuantity()


    //             ];
    //         }
    //     }

    //     Stripe::setApiKey(apiKey: 'sk_test_51NMaZ1CgL6WWsTB6mn8H05SdGckAZg5OLncjfJaEDQzjYU8WUt5Mcg1cv5wgcYSdS5wzZ5twBCdSM6xtdzmKeFFt00XSe9OxPs');


    //     $YOUR_DOMAIN = 'http://localhost:4242';

    // $checkout_session = \Stripe\Checkout\Session::create([
    //     'customer_email' => $user->getUserIdentifier(),
    //     'payment_method_types' => ['card'],
    //     'line_items' => [
    //         [
    //             $produitStripe
    //         ]
    //     ],
    //     'mode' => 'payment',
    //     'success_url' => $this->router->generate('confirmationLivraison', [], RouterInterface::ABSOLUTE_URL),
    //     'cancel_url' => $this->router->generate('payement_error', [], RouterInterface::ABSOLUTE_URL)
    // ]);

    //     return new RedirectResponse($checkout_session->url);
    // }

    // #[Route('/cart/error', name: 'payement_error')]


    // function stripeSuccess(CartManager $cartManager): RedirectResponse
    // {
    //     return $this->render('cart/error.html.twig');
    // }


}
