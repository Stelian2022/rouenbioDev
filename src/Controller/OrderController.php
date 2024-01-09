<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $tri = $request->query->get('tri');
        $dateTries = $orderRepository->trierDate();

        $triValide = ['id', 'userEmail', 'createdAt'];

        if (in_array($tri, $triValide)) {
            // Trie les utilisateurs en fonction de la valeur de tri
            $users = $orderRepository->findBy([], [$tri => 'DESC']);
        } else {
            // Par défaut, récupère tous les utilisateurs
            $users = $orderRepository->findAll();
        }
        $pageSize = 20; // Number of items per page
        $currentPages = $request->query->getInt('page', 1); // Get the current page from the request
        $pagination = $paginator->paginate(
            $users,
            $currentPages,
            $pageSize
        );
        $currentPage = 'Les commandes RouenBio';
        return $this->render('order/index.html.twig', [
            'currentPage' => $currentPage,
            'orders' => $orderRepository->findAll(),
            'nomsTries' => $dateTries,
            'pagination' => $pagination, // Pass the pagination object to the template
        ]);
    }

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order, OrderRepository $orderRepository): Response
    {
       
    
        if ($order) {
            $id = $order->getId();
            $currentPage = 'Commande nr ' . $id;
        }
       
        
        return $this->render('order/show.html.twig', [
            'order' => $order,
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
