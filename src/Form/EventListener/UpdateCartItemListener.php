<?php

namespace App\Form\EventListener;

use App\Manager\CartManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UpdateCartItemListener implements EventSubscriberInterface
{
    private $cartManager;
    private $entityManager;

    public function __construct(CartManager $cartManager, EntityManagerInterface $entityManager)
    {
        $this->cartManager = $cartManager;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];
    }

    public function onPostSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $cartItem = $form->getData();
        $cart = $cartItem->getOrderRef();
        $quantity = $cartItem->getQuantity();
        $this->cartManager->updateItemQuantity($cart, $cartItem, $quantity);
        $this->entityManager->flush();
    }
}
