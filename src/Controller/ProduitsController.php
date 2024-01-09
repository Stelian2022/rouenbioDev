<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Form\AddToCartType;
use App\Manager\CartManager;
use App\Repository\ProduitsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




#[Route('/produit')]
class ProduitsController extends AbstractController
{
    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $currentPage = 'Les Produits RouenBio';
        $page = $request->query->getInt('page', 1);
        $limit = 20; // Number of products per page
        $pagination = $paginator->paginate($produitsRepository->findAll(), $page, $limit);

        $imageProduit = str_replace("\\", "/", $this->getParameter('assets')) . "/img/imageProduits/";
        if (file_exists($imageProduit . $request->query->get('id') . ".jpg")) {
            $urlImg = "/assets/img/imageProduits/" . $request->query->get('id') . ".jpg";
        } else {
            $urlImg = "/assets/img/imageProduits/default.jpg";
        }
        return $this->render('view_produits/admin/index.html.twig', [
            'currentPage' => $currentPage,
            'pagination' => $pagination,
            'urlImg' => $urlImg,
        ]);
    }

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitsRepository $produitsRepository): Response
    {
        $currentPage = 'Ajouter un produit';
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitsRepository->save($produit, true);

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('view_produits/admin/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        $currentPage = 'Les Produits RouenBio';
        return $this->render('view_produits/admin/show.html.twig', [
            'produit' => $produit,
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);
        $currentPage = 'Les Produits RouenBio';
        if ($form->isSubmitted() && $form->isValid()) {
            $produitsRepository->save($produit, true);

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('view_produits/admin/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $produitsRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }


    // Produits details pour les utilisateurs

    #[Route('/produit/{id}', name: 'produit.detail', methods: ['GET'])]
    public function detail(Produits $produit, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);
        $currentPage = 'Ajouter dans votre panier';

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProduit($produit);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTimeImmutable());
            $cartManager->save($cart);
            return $this->redirectToRoute('cart');
            // return $this->redirectToRoute('produit.detail', ['id' => $produit->getId()]);
        }
        return $this->render('/produit/produit.detail.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
            'currentPage' => $currentPage

        ]);
    }
}
// methode test
// #[Route('/produit/{id}', name: 'produit.detail', methods: ['GET'])]
// public function detail(Produits $produit, Request $request, CartManager $cartManager): Response
// {
//     return $this->handleAddToCartForm($request, $produit, $cartManager);
// }
// private function handleAddToCartForm(Request $request, Produits $produit, CartManager $cartManager): Response
// {
//     $form = $this->createForm(AddToCartType::class);
//     $form->handleRequest($request);
//     $currentPage = 'Ajouter dans votre panier';

//     if ($form->isSubmitted() && $form->isValid()) {
//         $item = $form->getData();
//         $item->setProduit($produit);

//         $cart = $cartManager->getCurrentCart();
//         $cart
//             ->addItem($item)
//             ->setUpdatedAt(new \DateTimeImmutable());
//         $cartManager->save($cart);

//         // Redirection vers la page du panier après avoir ajouté un produit
//         return $this->redirectToRoute('cart');
//     }

//     return $this->render('/produit/produit.detail.html.twig', [
//         'produit' => $produit,
//         'form' => $form->createView(),
//         'currentPage' => $currentPage
//     ]);
// }
// #[Route('/Produits/Nos Produits Bio/fruits_legumes', name: 'fruits_legumes', methods: ['GET'])]
// public function fruitsEtLegumes(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator, CartManager $cartManager): Response
// {
//     // Logique spécifique pour la page des fruits et légumes

//     // Exemple : récupération des produits
//     $produits = $produitsRepository->findBy(['rayon' => 'Fruits et légumes']);

//     // ... autres logiques spécifiques à cette page

//     return $this->render('/Produits/Nos Produits Bio/fruits_legumes.html.twig', [
//         'produits' => $produits,
//         'form' => $this->createForm(AddToCartType::class)->createView(),
//         // ... autres variables à passer au template
//     ]);
// }