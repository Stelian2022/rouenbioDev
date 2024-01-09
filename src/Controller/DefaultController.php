<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Manager\CartManager;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default" , methods={"GET"})
     */
    public function menu(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();
        $menus = [
            'Accueil',
            'À propos' => [
                "L'Art de la simplicité",
                'Equipe',
                'Qui nous sommes',
                'Conseils personnalisés',
                'Les projets',
                'H2Origin',
            ],
            'Nos Produits Bio' => [
                'Fruits et légumes',
                'Produits frais',
                'Boissons',
                'Épiceries',
                'Pains',
                'Compléments alimentaires',
                'Cosmétiques',
                'Hygiène',
                'Bébé',
                'Maison et entretien',
                'Surgelés',
                'Cave à vin',
            ],
            'Éthique et mode de vie' => [
                'Le Vrac',
                'Le Vegan',
                'Sans gluten',
                'Produits locaux',
                'Producteurs locaux',
            ],
            'Bonnes Affaires' => [
                'Des prix au plus juste',

            ],
        ];
        $currentPage = "RouenBio";

        return $this->render('default/index.html.twig', [
            // 'default' => $default,
            // 'menus' => $menus,
            'cart' => $cart,
            'currentPage' => $currentPage,
           



        ]);
    }



    /**
     * @Route("/", name="default")
     */
    public function reviews(CartManager $cartManager)
    {

        $reviews = $this->getReviews();
        $cart = $cartManager->getCurrentCart();

        return $this->render('default/index.html.twig',  [
            'reviews' => $reviews,
            'cart' => $cart,
        ]);
    }
    private function getReviews()
    {

        $apiKey = 'AIzaSyAIZhR97WdqQjjllKAVw3gFlGrVQwzc_co';
        $placeId = 'ChIJm4Ervjze4EcRye06mq-yc3U';

        $client = HttpClient::create();

        try {
            $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/details/json', [
                'query' => [
                    'place_id' => $placeId,
                    'fields' => 'reviews',
                    'key' => $apiKey,
                    'language' => 'fr',
                ],
            ]);

            $content = $response->toArray();

            if (isset($content['result']['reviews'])) {
                return $content['result']['reviews'];
            } else {
                return [];
            }
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return [];
        }
    }
    /**
     * @Route("/", name="base")
     */
    public function currentPage(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();
        $currentPage = "RouenBio";
        return $this->render('base.html.twig',  [

            'currentPage' => $currentPage,
            'cart' => $cart,

        ]);
    }
       
}
