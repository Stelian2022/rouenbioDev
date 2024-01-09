<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Produits;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;





/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{


    private $security;

public function __construct(Security $security)
{
    $this->security = $security;
}
    /**
     * Creates an order.
     *
     * @return Order
     */
   
     public function create(): Order
     {
         $order = new Order();
         $order
             ->setStatus(Order::STATUS_CART)
             ->setCreatedAt(new \DateTimeImmutable())
             ->setUpdatedAt(new \DateTimeImmutable());
           
            
         return $order;
     }

       /**
     * Validate an order.
     *
     * @return User
     */
     public function validateOrder(): Order
     {
         $userEmail = $this->security->getUser()->getUserIdentifier();
         $order = new Order();
         $order
             ->setStatus(Order::STATUS_CART)
             ->setCreatedAt(new \DateTimeImmutable())
             ->setUpdatedAt(new \DateTimeImmutable())
             ->setUserEmail($userEmail);
         return $order;
     }

    /**
     * Creates an item for a product.
     *
     * @param Produits $produit
     *
     * @return OrderItem
     */
    public function createItem(Produits $produit): OrderItem
    {
        $item = new OrderItem();
        $item->setProduit($produit);
        $item->setQuantity(1);

        return $item;
    }
}