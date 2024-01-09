<?php

namespace App\Manager;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CartManager
 * @package App\Manager
 */
class CartManager
{
    /**
     * @var CartSessionStorage
     */
    private $cartSessionStorage;

    /**
     * @var OrderFactory
     */
    private $cartFactory;


    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * CartManager constructor.
     *
     * @param CartSessionStorage $cartStorage
     * @param OrderFactory $orderFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CartSessionStorage $cartStorage,
        OrderFactory $orderFactory,
        EntityManagerInterface $entityManager

    ) {
        $this->cartSessionStorage = $cartStorage;
        $this->cartFactory = $orderFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the current cart.
     * 
     * @return Order
     */
    public function getCurrentCart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart) {
            $cart = $this->cartFactory->create();
        }

        return $cart;
    }

    /**
     * Persists the cart in database and session.
     *
     * @param Order $cart
     */
    public function save(Order $cart): void
    {
        // Persist in database
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        // Persist in session
        $this->cartSessionStorage->setCart($cart);
    }

    public function clearCart(Order $cart): void
    {
        // Supprimer tous les articles du panier
        foreach ($cart->getItems() as $item) {
            $this->entityManager->remove($item);
        }

        $this->entityManager->flush();

        // Mettre à jour le panier en base de données
        $this->save($cart);
    }

    public function removeCartItem(OrderItem $item): self
    {
        // Remove the item from the cart object


        // Optionally, remove the item from the database
        $this->entityManager->remove($item);
        $this->entityManager->flush();

        return $this;
    }
    public function updateItemQuantity(Order $cart, OrderItem $item, int $quantity): void
    {
        $item->setQuantity($quantity);
        $this->save($cart);
    }
    
    
}
